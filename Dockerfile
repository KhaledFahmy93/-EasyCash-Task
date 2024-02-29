# Use the official PHP base image
FROM php:8.2-alpine

# Set the working directory inside the container
WORKDIR /var/www/html

# Install PHP extensions and dependencies
RUN docker-php-ext-install pdo_mysql

# Copy the project files into the container
COPY . .

# Expose the port used by the Lumen application
EXPOSE 8000

# Start the PHP built-in web server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]