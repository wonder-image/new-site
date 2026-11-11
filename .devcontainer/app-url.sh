#!/usr/bin/env bash
# Allinea APP_URL nel .env e lo stampa. APP_URL guida tutti gli URL generati:
# in Codespaces punta all'host https inoltrato (dietro proxy, da qui
# APP_TRUST_PROXY), altrove resta quello del .env o 127.0.0.1:8088.
set -euo pipefail
ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
ENV_TOOL="php $ROOT_DIR/.devcontainer/env.php"
PORT="${WONDER_PORT:-8088}"

if [ -n "${CODESPACE_NAME:-}" ] && [ -n "${GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN:-}" ]; then
  URL="https://${CODESPACE_NAME}-${PORT}.${GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN}"
  $ENV_TOOL set APP_URL "$URL"
  $ENV_TOOL set APP_TRUST_PROXY true
else
  URL="$($ENV_TOOL get APP_URL)"
  if [ -z "$URL" ]; then
    URL="http://127.0.0.1:${PORT}"
    $ENV_TOOL set APP_URL "$URL"
  fi
fi

echo "$URL"
