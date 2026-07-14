FROM php:8.1-fpm-bookworm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       libfreetype6-dev libjpeg62-turbo-dev libpng-dev libwebp-dev \
       libzip-dev libicu-dev libxml2-dev libonig-dev libxslt1-dev unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" \
       bcmath exif gd intl mbstring mysqli opcache pdo_mysql soap sockets xsl zip \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
