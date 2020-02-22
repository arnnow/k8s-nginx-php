FROM php:7.4-fpm-alpine

# Use the default production configuration
RUN apk add --no-cache $PHPIZE_DEPS \
    && apk add --no-cache libmemcached-libs zlib zlib-dev libmemcached-dev \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && pecl install redis-5.2.0RC1 \
    && pecl install memcached \
    && docker-php-ext-enable redis \
    && docker-php-ext-enable memcached

COPY files/ /app/
