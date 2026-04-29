FROM php:8.2-apache

# Installer les dépendances système et NodeJS pour compiler Vite
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
    libxml2-dev

# Nettoyage
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP (inclut pgsql pour la base de données PostgreSQL de Render)
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Autoriser Apache Rewrite
RUN a2enmod rewrite headers

# Définir le dossier public comme racine d'Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier les fichiers du projet
COPY . .

# Installer les dépendances PHP et NodeJS, et compiler les assets
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# Créer le lien symbolique du storage si non existant
RUN php artisan storage:link || true

# Droits et permissions pour Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Remplacer le port 80 par le port dynamique de Render
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
EXPOSE ${PORT}

# Lancer Apache au démarrage
CMD ["apache2-foreground"]
