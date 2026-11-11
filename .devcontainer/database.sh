#!/usr/bin/env bash
# Avvia (e al primo giro inizializza) MariaDB dentro il container.
# Ascolta solo su 127.0.0.1:3307, la porta di DB_HOSTNAME in .env.example.
# Idempotente: se il server risponde già non fa nulla.
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
LOCAL_DIR="$ROOT_DIR/.devcontainer/.local"
DATA_DIR="$LOCAL_DIR/mysql"
# Socket e PID fuori dal workspace: sui bind mount macOS i socket unix non sono affidabili.
SOCKET="/tmp/wonder-mysqld.sock"
PID_FILE="/tmp/wonder-mysqld.pid"
LOG_FILE="$LOCAL_DIR/mysqld.log"
ADMIN_FILE="$LOCAL_DIR/db-admin.env"
DB_PORT="${WONDER_DB_PORT:-3307}"

mkdir -p "$LOCAL_DIR"
chmod 700 "$LOCAL_DIR"

ping_db() {
  mariadb-admin --no-defaults --socket="$SOCKET" -uroot ping >/dev/null 2>&1
}

if ping_db; then
  echo "✅ MariaDB già attivo su 127.0.0.1:$DB_PORT"
  exit 0
fi

if [ ! -d "$DATA_DIR/mysql" ]; then
  echo "🗄️  Inizializzo MariaDB in .devcontainer/.local/mysql"
  mariadb-install-db --no-defaults --datadir="$DATA_DIR" \
    --auth-root-authentication-method=normal --skip-test-db >/dev/null
fi

setsid nohup mariadbd --no-defaults \
  --datadir="$DATA_DIR" \
  --socket="$SOCKET" \
  --pid-file="$PID_FILE" \
  --bind-address=127.0.0.1 \
  --port="$DB_PORT" \
  --skip-name-resolve \
  --skip-log-bin \
  --innodb-buffer-pool-size=64M \
  --log-error="$LOG_FILE" >/dev/null 2>&1 &

for _ in $(seq 1 60); do
  ping_db && break
  sleep 1
done

if ! ping_db; then
  echo "❌ MariaDB non risponde. Log: $LOG_FILE" >&2
  tail -n 30 "$LOG_FILE" >&2 || true
  exit 1
fi

# Utente admin via TCP per `php forge db:init` (root resta solo sul socket).
if [ ! -f "$ADMIN_FILE" ]; then
  ADMIN_PASSWORD="$(head -c 48 /dev/urandom | base64 | tr -dc 'A-Za-z0-9' | head -c 24)"
  mariadb --no-defaults --socket="$SOCKET" -uroot <<SQL
CREATE USER IF NOT EXISTS 'devadmin'@'127.0.0.1' IDENTIFIED BY '$ADMIN_PASSWORD';
CREATE USER IF NOT EXISTS 'devadmin'@'localhost' IDENTIFIED BY '$ADMIN_PASSWORD';
GRANT ALL PRIVILEGES ON *.* TO 'devadmin'@'127.0.0.1' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON *.* TO 'devadmin'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;
SQL
  (umask 077; printf 'DB_ADMIN_USER=devadmin\nDB_ADMIN_PASSWORD=%s\n' "$ADMIN_PASSWORD" > "$ADMIN_FILE")
fi

echo "✅ MariaDB attivo su 127.0.0.1:$DB_PORT"
