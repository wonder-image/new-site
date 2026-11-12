#!/usr/bin/env bash
# Controlla versioni ed estensioni PHP richieste da composer.lock.
set -euo pipefail
cd "$(dirname "${BASH_SOURCE[0]}")/.."

php -v | head -n 1
composer --version
echo "node $(node --version) — npm $(npm --version)"

missing=0
for ext in ctype curl dom fileinfo filter gd hash iconv json libxml mbstring mysqli pcre simplexml xml xmlreader xmlwriter zip zlib; do
  if ! php -m | grep -qix "$ext"; then
    echo "❌ Estensione PHP mancante: $ext" >&2
    missing=1
  fi
done
[ "$missing" -eq 0 ] && echo "✅ Estensioni PHP presenti"

# ffmpeg/ffprobe: resize dei video e copertine
for bin in ffmpeg ffprobe; do
  if command -v "$bin" >/dev/null 2>&1; then
    echo "✅ $("$bin" -version | head -n 1)"
  else
    echo "❌ $bin mancante: ricostruisci il container (Dev Containers: Rebuild Container)" >&2
    missing=1
  fi
done

if [ -f composer.lock ]; then
  composer check-platform-reqs --lock --no-interaction
fi

exit "$missing"
