FROM php:7.4-fpm

# Install PHP extensions and PECL modules.
RUN buildDeps=" \
      libpng-dev \
      libonig-dev \
      zlib1g-dev \
      libzip-dev \
    " \
    runtimeDeps=" \
      curl \
      git \
    " \
 && apt-get update \
 && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends $buildDeps $runtimeDeps \
 && docker-php-ext-install bcmath mbstring mysqli opcache pdo_mysql zip \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

# Copy ini files.
COPY php.ini /usr/local/etc/php/

# Declare default environment variables.
ENV PHP_IDE_CONFIG 'serverName=localhost'

WORKDIR /srv

CMD php-fpm
