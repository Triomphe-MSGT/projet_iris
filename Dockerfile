FROM php:8.2-apache

# Installer les dépendances système et NodeJS
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    nodejs \
    npm \
    libonig-dev \
    libxml2-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP indispensables
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Configuration Apache
RUN a2enmod rewrite headers
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Installation sécurisée des dépendances (évite l'erreur exit code 2)
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install && npm run build

# Gestion des permissions
RUN php artisan storage:link || true
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Gestion du port dynamique Render
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

CMD ["apache2-foreground"]