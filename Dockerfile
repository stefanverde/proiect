FROM php:8.1-apache-buster

# Install MySQLi extension
RUN docker-php-ext-install mysqli