FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atualiza o symfony/flex antes de instalar as dependências
RUN composer update symfony/flex --no-interaction --prefer-dist --optimize-autoloader

# Instala as dependências PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN chown -R www-data:www-data var

EXPOSE 9000

CMD ["php-fpm"]