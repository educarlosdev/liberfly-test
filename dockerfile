FROM composer:latest as composer
FROM php:8-fpm

WORKDIR /usr/src/api

# copy composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# install packages
RUN apt-get update
RUN apt-get install -y libpq-dev
RUN apt-get install -y git
#RUN apt-get install -y mysql-client

# install php extensions and libs
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install xdebug
RUN pecl install openswoole-22.0.0

# enable php extensions
RUN docker-php-ext-enable openswoole
RUN docker-php-ext-enable xdebug
RUN docker-php-ext-enable pdo_mysql

COPY . .
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-enable zip
# install dependencies
RUN composer update
