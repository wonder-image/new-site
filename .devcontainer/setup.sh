#!/usr/bin/env bash
# postCreateCommand: dipendenze, database e generazione runtime.
# Idempotente: si può rilanciare a mano con `bash .devcontainer/setup.sh`.
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
LOCAL_DIR="$ROOT_DIR/.devcontainer/.local"
ENV_TOOL="php $ROOT_DIR/.devcontainer/env.php"
cd "$ROOT_DIR"

export COMPOSER_NO_INTERACTION=1
# Niente tentativi di connessione Xdebug durante i comandi di setup.
export XDEBUG_MODE="${XDEBUG_MODE:-off}"
mkdir -p "$LOCAL_DIR"
chmod 700 "$LOCAL_DIR"

echo "── Verifica ambiente"
bash .devcontainer/verify.sh || echo "⚠️  Verifica ambiente con avvisi: controlla l'output sopra"

# .env: se manca parte da .env.example con un APP_DOMAIN ricavato dalla
# cartella (`nome-tld` → `nome.tld`), così `forge config` non chiede nulla.
if [ ! -f .env ]; then
  cp .env.example .env
  chmod 600 .env
  folder="$(basename "$ROOT_DIR")"
  if [[ "$folder" == *-* ]]; then
    domain="${folder%-*}.${folder##*-}"
  else
    domain="$folder.local"
  fi
  $ENV_TOOL set APP_DOMAIN "$domain"
  echo "✅ .env creato da .env.example (APP_DOMAIN=$domain)"
fi

# La APP_KEY di esempio non è una chiave valida: vuota, così `forge config`
# ne genera una nuova.
if [ "$($ENV_TOOL get APP_KEY)" = "change_me_with_a_random_key" ]; then
  $ENV_TOOL set APP_KEY ""
fi

echo "── composer install (esegue anche php forge config → npm install)"
composer install --no-interaction </dev/null

echo "── Database"
bash .devcontainer/database.sh
# shellcheck disable=SC1091
source "$LOCAL_DIR/db-admin.env"

DB_USERNAME_ENV="$($ENV_TOOL get DB_USERNAME)"
DB_PASSWORD_ENV="$($ENV_TOOL get DB_PASSWORD)"

if [ -z "$DB_USERNAME_ENV" ] || [ -z "$DB_PASSWORD_ENV" ] \
  || [ "$DB_USERNAME_ENV" = "sf8_test_user" ] || [ "$DB_PASSWORD_ENV" = "sf8_test_password" ]; then
  # .env nuovo: forge genera nome DB, utente e password.
  php forge db:init --force --no-interaction \
    --admin-host=127.0.0.1 \
    --admin-port=3307 \
    --admin-username="$DB_ADMIN_USER" \
    --admin-password="$DB_ADMIN_PASSWORD" \
    --db-hostname=127.0.0.1:3307 \
    --app-domain="$($ENV_TOOL get APP_DOMAIN)" </dev/null
else
  # .env con credenziali reali (setup già fatto, o cartella condivisa con
  # l'host): non lo tocca, allinea nel MariaDB del container database e utente.
  php .devcontainer/db-from-env.php | mariadb --no-defaults --socket=/tmp/wonder-mysqld.sock -uroot
  echo "✅ Database e utente allineati al .env"
  db_host="$($ENV_TOOL get DB_HOSTNAME)"
  if [ "$db_host" != "127.0.0.1:3307" ]; then
    echo "⚠️  DB_HOSTNAME=$db_host: nel container il database è su 127.0.0.1:3307" >&2
  fi
fi

echo "APP_URL=$(bash .devcontainer/app-url.sh)"

echo "── php forge update --local"
php forge update --local --no-interaction </dev/null

echo "✅ Setup completato. Il server parte con .devcontainer/start.sh"
