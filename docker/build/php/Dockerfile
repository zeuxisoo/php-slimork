FROM php:7.1.20-fpm

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update \
    && apt-get install -q -y --assume-yes apt-utils \
       exim4 mailutils libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng-dev libmcrypt-dev \
       libcurl3 libcurl4-openssl-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install gd mysqli pdo pdo_mysql zip gettext mcrypt curl

RUN pecl install xdebug-2.6.1

RUN echo "localhost localhost.localdomain" >> /etc/hosts

WORKDIR /slimork

EXPOSE 9000

CMD ["php-fpm"]
