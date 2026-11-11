#!/usr/bin/env bash
# Legge su stdin l'output JSON di `bws secret list` e:
#   - maschera ogni valore nei log (riga per riga: ::add-mask:: copre una riga sola);
#   - esporta ogni secret in $GITHUB_ENV con un delimitatore casuale;
#   - scrive in .env (argomento 1, default .env) i secret destinati alla produzione,
#     quotati per phpdotenv quando serve.
#
# phpdotenv non accetta spazi nei valori senza virgolette (fatal su tutto il sito)
# e tronca a `#`: ogni valore fuori da un set sicuro va tra doppi apici, con
# \ " $ e gli a capo escapati. I valori già sicuri restano identici a prima.
set -euo pipefail

env_file="${1:-.env}"
: "${GITHUB_ENV:?GITHUB_ENV non impostata}"

dotenv_value() {
  local v="$1"
  v="${v//$'\r'/}"
  if [[ "$v" =~ ^[A-Za-z0-9_./:@+,=-]*$ ]]; then
    printf '%s' "$v"
    return
  fi
  v="${v//\\/\\\\}"
  v="${v//\"/\\\"}"
  v="${v//\$/\\\$}"
  v="${v//$'\n'/\\n}"
  printf '"%s"' "$v"
}

while IFS= read -r item; do
  key="$(jq -r '.key' <<<"$item")"
  value="$(jq -r '.value' <<<"$item")"

  if [[ ! "$key" =~ ^[A-Za-z_][A-Za-z0-9_]*$ ]]; then
    echo "::warning::Secret con nome non valido ignorato (solo lettere, cifre e _)."
    continue
  fi

  while IFS= read -r line; do
    [ -n "$line" ] && echo "::add-mask::$line"
  done <<<"$value"

  delimiter="ghadelimiter_$(openssl rand -hex 16)"
  printf '%s<<%s\n%s\n%s\n' "$key" "$delimiter" "$value" "$delimiter" >> "$GITHUB_ENV"

  case "$key" in
    # Servono solo al runner, non in produzione
    FTP_*|BWS_*|CLOUDFLARE_*) ;;
    *) printf '%s=%s\n' "$key" "$(dotenv_value "$value")" >> "$env_file" ;;
  esac
done < <(jq -c '.[] | select(.key != null and .value != null)')
