FROM php:7.2-apache-stretch

ARG phalcon_version='v3.4.3'
ARG env='prod'

RUN apt update --fix-missing;
RUN apt install -y wget curl gnupg zip unzip libzip-dev

RUN docker-php-ext-install zip

RUN apt-get install -y git

RUN cd /tmp && git clone "https://github.com/phalcon/cphalcon.git"
RUN cd /tmp/cphalcon && git checkout tags/$phalcon_version -b $phalcon_version

RUN apt install gcc libpcre3-dev libpq-dev -y

RUN cd /tmp/cphalcon/build && ./install

RUN docker-php-ext-enable phalcon

RUN docker-php-ext-install pdo pdo_pgsql pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite

RUN /etc/init.d/apache2 restart