FROM php:8.2-apache

# Устанавливаем необходимые расширения PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Копируем файлы проекта в контейнер
WORKDIR /var/www/html
COPY . .

# Устанавливаем права
RUN chown -R www-data:www-data /var/www/html

# Запускаем Apache
CMD ["apache2-foreground"]
