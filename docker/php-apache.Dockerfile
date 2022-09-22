FROM php:8.0-apache

# Install system dependencies
RUN apt-get update && apt-get upgrade

RUN apt-get install -y \
	git \
	curl \
	libpng-dev \
	libonig-dev \
	libxml2-dev \
	zip \
	unzip

# php: pdo mysql
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql

# php: imagemagick
RUN apt-get install -y imagemagick libmagickwand-dev --no-install-recommends \
	&& pecl install imagick \
	&& docker-php-ext-enable imagick

# php: mbstring, zip, gd
RUN docker-php-ext-install mbstring && docker-php-ext-enable mbstring
RUN apt-get install -y libzip-dev \
	&& docker-php-ext-install zip && docker-php-ext-enable zip

# php: gd

RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
	&& docker-php-ext-configure gd --with-freetype=/usr/incldue --with-jpeg=/usr/include \
	&& docker-php-ext-install gd \
	&& docker-php-ext-enable gd
#RUN docker-php-ext-install sodium && docker-php-ext-enable sodium

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

## Copy in files
#COPY . /var/www/html/

# Enable mod_rewrite
RUN ["a2enmod", "rewrite"]

# Ensure apache runs
CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]