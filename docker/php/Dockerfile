FROM php:8.1-apache

RUN apt-get update -qq && \
    apt-get install -qy \
    git \
    gnupg \
    unzip \
    zip && \
    docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite

COPY conf/php.ini /usr/local/etc/php/conf.d/app.ini
COPY conf/vhost.conf /etc/apache2/sites-available/000-default.conf
