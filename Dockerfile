FROM php:8.2-cli

# Cài extension cần thiết
RUN docker-php-ext-install pdo pdo_mysql

# Cài composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 10000

CMD php -S 0.0.0.0:10000 -t public
