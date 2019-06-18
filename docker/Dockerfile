FROM php:7.3-apache

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# xdebug
RUN apt-get update \
    && pecl install xdebug-2.7.2 \
    && docker-php-ext-enable xdebug 

# php configurations
COPY conf.d/* /usr/local/etc/php/conf.d/

# redirect to samples folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/docs
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-enabled/*.conf