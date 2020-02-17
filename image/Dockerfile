FROM php:7.4-fpm-alpine

# Use the default production configuration
RUN apk add --no-cache $PHPIZE_DEPS \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && pecl install redis-5.1.1 \
    && docker-php-ext-enable redis 
