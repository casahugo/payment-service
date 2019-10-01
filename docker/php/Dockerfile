FROM php:7.3.8-fpm

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# https://github.com/docker-library/php/issues/61
RUN apt-get update \
    && apt-get install -y --fix-missing \
        apt-utils \
        gnupg \
        vim \
    && echo "deb http://packages.dotdeb.org jessie all" >> /etc/apt/sources.list \
    && echo "deb-src http://packages.dotdeb.org jessie all" >> /etc/apt/sources.list \
    && curl -sS --insecure https://www.dotdeb.org/dotdeb.gpg | apt-key add - \
    && apt-get update \
    && apt-get install -y \
        zlib1g-dev \
        libzip-dev \
    && docker-php-ext-install bcmath pdo_mysql sockets zip \
    && apt-get install -y unzip git

ARG UID=1000
RUN useradd -ms /bin/bash --uid ${UID} wizaplace \
    && usermod -a -G www-data wizaplace

RUN echo "date.timezone = Europe/Paris" > /usr/local/etc/php/conf.d/timezone.ini
RUN echo "memory_limit = 256M" > /usr/local/etc/php/conf.d/memory.ini

USER wizaplace

WORKDIR /var/www/html