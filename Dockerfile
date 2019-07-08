FROM php:7.2-apache

# Install deb packages
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash
RUN apt-get update 
RUN apt-get install -y curl nodejs vim git libzip-dev zip libpng-dev libxml2-dev gnupg2 apt-transport-https

# Install required PHP extensions
RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-install gd iconv mbstring pdo pdo_mysql zip xml json

# Install Dockerize
ENV DOCKERIZE_VERSION v0.6.1
RUN apt-get install -y wget
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Disable the warning about running commands as root
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install Yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install yarn

# Create App directory
RUN mkdir /var/www/html/app
WORKDIR /var/www/html/app

# Copy the app
COPY . ./

# Install Dependancies

# PHP dependancies
RUN composer install --prefer-dist --no-progress --no-suggest

RUN nodejs -v
# JS dependancies
RUN yarn install

# Compile assets 
RUN bin/console assets:install

# Apache2 Configuration
COPY docker/app.conf /etc/apache2/sites-available/app.conf
RUN usermod -u 1000 www-data
RUN a2ensite app.conf
RUN a2enmod rewrite
RUN service apache2 restart