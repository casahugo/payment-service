FROM php:7.1.3-fpm

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# https://github.com/docker-library/php/issues/61
RUN apt-get update \
    && apt-get install -y \
        zlib1g-dev \
        libzip-dev \
        zip \
        unzip

ARG UID=1000
RUN useradd -ms /bin/bash --uid ${UID} payment \
    && usermod -a -G www-data payment

RUN echo "date.timezone = Europe/Paris" > /usr/local/etc/php/conf.d/timezone.ini
RUN echo "memory_limit = 256M" > /usr/local/etc/php/conf.d/memory.ini

USER payment

WORKDIR /var/www/html
