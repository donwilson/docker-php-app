FROM php:8.2-apache

# add in composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install system dependencies
#RUN apt-get update && apt-get -y upgrade
RUN apt-get update && apt-get install -y curl zip unzip zlib1g-dev

# install specific command line tools
RUN apt-get update && apt-get install -y webp pngquant libjpeg-turbo-progs

# php: pdo mysql
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql

# php: memcache
RUN apt-get update && apt-get install -y git libmemcached-dev \
	&& git clone https://github.com/php-memcached-dev/php-memcached /usr/src/php/ext/memcached \
	&& docker-php-ext-configure /usr/src/php/ext/memcached \
	&& docker-php-ext-install /usr/src/php/ext/memcached \
	&& rm -rf /usr/src/php/ext/memcached

# php: imagemagick
RUN apt-get update && apt-get install -y imagemagick libmagickwand-dev --no-install-recommends \
	&& pecl install imagick \
	&& docker-php-ext-enable imagick

# php: mbstring
RUN apt-get update && apt-get install -y libonig-dev \
	&& docker-php-ext-install mbstring && docker-php-ext-enable mbstring

# php: zip
RUN apt-get update && apt-get install -y libzip-dev \
	&& docker-php-ext-install zip && docker-php-ext-enable zip

# php: gd
RUN apt-get update && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
	&& docker-php-ext-configure gd --with-freetype=/usr/incldue --with-jpeg=/usr/include \
	&& docker-php-ext-install gd \
	&& docker-php-ext-enable gd

# php: exif
RUN apt-get update && docker-php-ext-install exif

# clear apt cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

## Copy in files
#COPY . /var/www/html/

# Enable mod_rewrite
RUN ["a2enmod", "rewrite"]

# Enable mod_headers
RUN ["a2enmod", "headers"]

# Ensure apache runs
CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]