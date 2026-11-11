#!/usr/bin/env bash
# Minifica sul posto CSS e JS del sito in assets/{ASSETS_VERSION}/{css,js}.
# Niente bundle e niente format: i nomi globali degli script classici restano
# intatti, url() e import non vengono toccati. Esclusi css/set-up/ (generato
# dal server all'update) e i file già *.min.*. Output deterministico: l'FTP
# ricarica solo i file cambiati.
set -euo pipefail

assets_dir="${1:?Uso: minify-assets.sh assets/<versione>}"
assets_dir="${assets_dir%/}"
esbuild="${ESBUILD:-npx --yes esbuild@0.28.2}"

files=()
while IFS= read -r -d '' f; do
  files+=("$f")
done < <(
  find "$assets_dir/css" "$assets_dir/js" -type f \( -name '*.css' -o -name '*.js' \) \
    ! -path "$assets_dir/css/set-up/*" ! -name '*.min.*' -print0 2>/dev/null | sort -z
)

if [ "${#files[@]}" -eq 0 ]; then
  echo "Nessun CSS/JS da minificare in $assets_dir"
  exit 0
fi

before=$(cat "${files[@]}" | wc -c)

$esbuild "${files[@]}" --minify --charset=utf8 --legal-comments=none --log-level=warning \
  --outbase="$assets_dir" --outdir="$assets_dir" --allow-overwrite

after=$(cat "${files[@]}" | wc -c)
printf '%s\n' "${files[@]}"
echo "Minificati ${#files[@]} file: $((before)) → $((after)) byte"
