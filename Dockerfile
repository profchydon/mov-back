FROM php:8.1-fpm

# setup user as root
USER root

WORKDIR /var/www

# setup node js source will be used later to install node js
RUN curl -sL https://deb.nodesource.com/setup_16.x -o nodesource_setup.sh
RUN ["sh",  "./nodesource_setup.sh"]

# Install environment dependencies
RUN apt-get update \
	# gd
	&& apt-get install -y build-essential  openssl nginx libfreetype6-dev libjpeg-dev libpng-dev libwebp-dev zlib1g-dev libzip-dev gcc g++ make vim unzip curl git jpegoptim optipng pngquant gifsicle locales libonig-dev nodejs  \
	&& docker-php-ext-configure gd  \
	&& docker-php-ext-install gd \
	# gmp
	&& apt-get install -y --no-install-recommends libgmp-dev \
	&& docker-php-ext-install gmp \
	# pdo_mysql
	&& docker-php-ext-install pdo_mysql mbstring \
	# pdo
	&& docker-php-ext-install pdo pdo_pgsql \
	# opcache
	&& docker-php-ext-enable opcache \
	# exif
    && docker-php-ext-install exif \
    && docker-php-ext-install sockets \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install bcmath \
	# zip
	&& docker-php-ext-install zip \
	&& apt-get autoclean -y \
	&& rm -rf /var/lib/apt/lists/* \
	&& rm -rf /tmp/pear/

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

