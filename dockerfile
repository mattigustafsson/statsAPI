FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update -yqq \
    && apt-get install git libzip-dev zlib1g-dev libsqlite3-dev -y \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pdo_sqlite

RUN curl -fsSL https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer global require phpunit/phpunit ^10.3 --no-progress --no-scripts --no-interaction

ENV PATH /root/.composer/vendor/bin:$PATH

RUN a2enmod rewrite
COPY rest.conf /etc/apache2/sites-enabled/000-default.conf

COPY app/public/ .
COPY app/src/ .
COPY .env .
COPY tests .
COPY / .

RUN composer dump-autoload

# Expose port 80 for Apache
EXPOSE 80

# Start the Apache web server
CMD ["apache2-foreground"]