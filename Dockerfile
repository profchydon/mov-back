FROM php:8.1-fpm

# setup user as root
USER root

WORKDIR /var/www
ENV TZ=Africa/Lagos

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/


# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libpq-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    git \
    curl \
    lua-zlib-dev \
    libmemcached-dev \
    nginx

# Install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mbstring pdo_mysql zip exif pcntl gd memcached pdo pdo_pgsql

# Copy files
COPY . /var/www

# Copy nginx/php/supervisor configs
RUN cp ./docker/supervisord.conf /etc/supervisord.conf
RUN cp ./docker/php.ini /usr/local/etc/php/conf.d/php.ini
RUN cp ./docker/nginx.conf /etc/nginx/sites-enabled/default

RUN chmod +rwx /var/www

RUN chmod -R 777 /var/www

# setup FE
RUN npm install

# setup composer and laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Deployment steps
RUN composer install --ignore-platform-reqs --working-dir="/var/www"
RUN composer dump-autoload --working-dir="/var/www"

RUN chmod +x /var/www/docker/run.sh

EXPOSE 80

ENTRYPOINT ["/var/www/docker/run.sh"]

