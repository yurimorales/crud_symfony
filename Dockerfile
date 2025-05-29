FROM php:7.4-fpm

# Install system dependencies    
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia o projeto para dentro do container
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atualiza o symfony/flex antes de instalar as dependências
RUN composer update symfony/flex --no-interaction --prefer-dist --optimize-autoloader

# Instala as dependências PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Ajusta permissões da pasta var (sempre)
RUN chown -R www-data:www-data var

# Ajusta permissões da pasta public/uploads (somente se existir)
RUN [ -d public/uploads ] && \
    chown -R www-data:www-data public/uploads && \
    chmod -R 775 public/uploads || true

EXPOSE 9000

CMD ["php-fpm"]
