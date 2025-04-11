FROM php:8.4-apache
RUN apt update
# Install Additional System Dependencies
RUN apt install -y libzip-dev zip
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip
# Copy the application code
COPY . /var/www/html
COPY .env /var/www/html
# Set the working directory
WORKDIR /var/www/html
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Install project dependencies
# RUN composer install
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
COPY 000-default.conf /etc/apache2/sites-enabled/
# Enable Apache modules
RUN a2enmod rewrite
RUN apachectl restart
RUN chown -R root:root /var/www/html
RUN chmod -R 777 /var/www/html