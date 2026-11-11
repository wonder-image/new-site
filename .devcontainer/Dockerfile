# Ambiente di sviluppo Wonder Image: PHP 8.2 (come la CI di deploy) + MariaDB.
# Node arriva dalla feature devcontainer (versione allineata a .nvmrc).
FROM mcr.microsoft.com/devcontainers/php:8.2-bookworm

USER root

RUN apt-get update \
 && apt-get install -y --no-install-recommends \
      libfreetype6-dev libjpeg62-turbo-dev libpng-dev libwebp-dev \
      libzip-dev libonig-dev libicu-dev \
      mariadb-server mariadb-client \
 && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
 && docker-php-ext-install -j"$(nproc)" gd mbstring mysqli pdo_mysql zip exif intl bcmath \
 && rm -rf /var/lib/apt/lists/*

USER vscode
