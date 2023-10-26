FROM php:8.1-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update \
    && apt-get install -y \
        zlib1g-dev \
        libicu-dev \
        libzip-dev \
        libonig-dev \
        g++ \
        git \
        vim \
        curl \
        zip \
        libpq-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install \
        zip \
        sysvsem \
    && docker-php-ext-install -j$(nproc) mbstring \
    && docker-php-ext-install -j$(nproc) pdo \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pgsql \

#RUN #curl -s https://getcomposer.org/installer | php
#RUN #alias composer='php composer.phar'
# Add user for laravel application
#RUN groupadd -g 1000 lottery
#RUN useradd -u 1000 -ms /bin/bash -g lottery lottery

# Copy existing application directory contents
#COPY ../project /var/www

# Copy existing application directory permissions
#COPY --chown=lottery:lottery . /var/www

# Change current user to www
#USER lottery
