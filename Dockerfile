FROM composer:1.8.4 AS composer
WORKDIR /var/www/html
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY composer.phar .
COPY composer.json .
COPY composer.lock .
RUN composer install --no-scripts


FROM php:7.2-apache
## System-wide packages
RUN apt-get update && \
    apt-get install -y -q \
        git \
        zlib1g-dev \
        libpng-dev \
        zlib1g-dev \
        libgmp-dev \
        libz-dev \
        curl \
        wget \
        libzip4 \
        telnet \
        libzip-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        imagemagick \
        imagemagick-common \
        libmagickwand-dev \
        libmagickcore-dev \
        nano \
        git \
        libpng-dev \
        zlib1g-dev \
        libzip4 \
        libzip-dev \
        imagemagick \
        imagemagick-common \
        libmagickwand-dev \
        libmagickcore-dev \
        python \
        python-dev \
        python-pip \
        python-setuptools \
        groff \
        less \
        && pip install --upgrade awscli \
        && apt-get clean \
        && rm -r /var/lib/apt/lists/*
## PHP Extensions
RUN pecl install imagick \
    && docker-php-ext-enable opcache \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install exif \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip \
    && docker-php-ext-install mbstring

# Use the default production configuration
COPY .docker/web/php.ini /usr/local/etc/php/
COPY .docker/web/opcache.ini /usr/local/etc/php/conf.d/
COPY .docker/web/000-default.conf /etc/apache2/sites-enabled/

## Apache modules
RUN a2enmod rewrite && a2enmod headers
ENV APACHE_SERVER_NAME apigility
ENV APACHE_SERVER_ADMIN help@example.com
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

COPY .docker/web/secrets_entrypoint.sh /usr/local/bin/secrets_entrypoint.sh
RUN chmod 755 /usr/local/bin/secrets_entrypoint.sh


## Project files
COPY composer.json composer.json
COPY composer.lock composer.lock
COPY composer.phar composer.phar
COPY phpunit.xml phpunit.xml
COPY config config
COPY module module
COPY public public
COPY src src

COPY --from=composer /var/www/html/vendor vendor
COPY config/autoload/doctrine-orm.global.php.dist config/autoload/doctrine-rom.global.php
##RUN /var/www/html/vendor/bin/doctrine-module orm:generate:proxies
RUN mkdir -p /var/www/html/cache && chmod 0777 /var/www/html/cache
RUN mkdir -p /var/www/html/data/cache && chmod -R 0777 /var/www/html/data
RUN ls -al /var/www/html

ENTRYPOINT ["secrets_entrypoint.sh"]
CMD ["apache2-foreground"]

## This could be mounted by the Host OS to a persistent volume like an EBS volume in AWS or NFS if there is a clustered requirements.
### Using NFS inside of a docker-container is not advised because that requires special privileges. Do that on the host and use something like bindFS to re-map UIDs/GIDs
VOLUME "/var/www/html/data"