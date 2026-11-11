#!/usr/bin/env bash
# postStartCommand: avvia MariaDB e il server PHP in background sulla porta 8088.
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
LOCAL_DIR="$ROOT_DIR/.devcontainer/.local"
PORT="${WONDER_PORT:-8088}"
PID_FILE="$LOCAL_DIR/server.pid"
LOG_FILE="$LOCAL_DIR/server.log"
cd "$ROOT_DIR"
# Xdebug spento di default: per il debug `XDEBUG_MODE=debug bash .devcontainer/start.sh`.
export XDEBUG_MODE="${XDEBUG_MODE:-off}"

mkdir -p "$LOCAL_DIR"
chmod 700 "$LOCAL_DIR"

bash .devcontainer/database.sh

if [ ! -f .env ]; then
  echo "⚠️  .env mancante: lancia prima bash .devcontainer/setup.sh" >&2
  exit 1
fi

URL="$(bash .devcontainer/app-url.sh)"

# Ferma un server precedente solo se è davvero il nostro.
if [ -f "$PID_FILE" ]; then
  old_pid="$(cat "$PID_FILE")"
  if [ -n "$old_pid" ] && ps -p "$old_pid" -o args= 2>/dev/null | grep -q "0.0.0.0:${PORT}"; then
    kill "$old_pid" 2>/dev/null || true
    sleep 1
  fi
  rm -f "$PID_FILE"
fi

setsid nohup php -S "0.0.0.0:${PORT}" -t "$ROOT_DIR" "$ROOT_DIR/.devcontainer/router.php" >"$LOG_FILE" 2>&1 &
echo $! > "$PID_FILE"

status=000
for _ in $(seq 1 20); do
  status="$(curl -s -o /dev/null -w '%{http_code}' "http://127.0.0.1:${PORT}/" || true)"
  [ "$status" != "000" ] && break
  sleep 0.5
done

if [ "$status" != "000" ] && [ "$status" -lt 500 ]; then
  echo "✅ Sito attivo: $URL (HTTP $status)"
  echo "   Log: .devcontainer/.local/server.log"
  exit 0
fi

echo "❌ Il server PHP risponde HTTP $status. Log:" >&2
tail -n 30 "$LOG_FILE" >&2 || true
exit 1
