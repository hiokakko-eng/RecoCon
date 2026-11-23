# 開発用: 本番PHPのバージョンが確認できたらbuild.args.PHP_VERSIONを合わせる
ARG PHP_VERSION=8.3
FROM php:${PHP_VERSION}-apache

RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
       libonig-dev msmtp msmtp-mta ca-certificates \
    && docker-php-ext-install -j$(nproc) pdo_mysql mbstring \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

COPY docker/php/apache-recocon.conf /etc/apache2/conf-available/recocon.conf
COPY docker/php/php-dev.ini /usr/local/etc/php/conf.d/zz-recocon.ini
COPY docker/php/msmtprc /etc/msmtprc
RUN a2enconf recocon && chmod 0644 /etc/msmtprc
WORKDIR /var/www/html
