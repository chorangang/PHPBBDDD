FROM php:8.3.3-fpm

COPY php.ini /usr/local/etc/php/

RUN apt-get update && apt-get install -y \
	git \
	curl \
	zip \
	unzip \
    && docker-php-ext-install pdo_mysql

WORKDIR /var/www