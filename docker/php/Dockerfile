# Use an official PHP image with Apache based on Debian Buster
FROM php:8.1-apache-buster

# Set the server name for Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Use a Debian mirror instead of the Ubuntu mirror
RUN sed -i -e 's/http:\/\/mirrors.ubuntu.com/https:\/\/deb.debian.org/g' /etc/apt/sources.list

# Install required packages
RUN apt-get update && apt-get install -y \
    cron \
    vim \
    locales \
    git \
    libicu-dev \
    g++ \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    libxslt-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configure locales
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --disable-tls --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql mysqli gd opcache intl zip calendar dom mbstring zip gd xsl
RUN a2enmod rewrite

# Install APCu
RUN pecl install apcu && docker-php-ext-enable apcu

# Install amqp extension using the extension installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp

# Set working directory
WORKDIR /var/www
