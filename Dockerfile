# Use an official PHP image as the base image
FROM php:8.1-apache
# Set the working directory in the container
WORKDIR /var/www/html

# Copy the application files to the container
COPY . /var/www/html/

# Expose the port on which your application will run
EXPOSE 80

# Modify ports.conf to set ServerName
RUN sed -i.bak -e 's/Listen 80/Listen 80\nServerName localhost/' /etc/apache2/ports.conf


# Install mysqli extension for MySQL database support
RUN docker-php-ext-install mysqli

# Set up Apache: enable rewrite module and restart Apache
RUN a2enmod rewrite && service apache2 restart


# Start the Apache server
CMD ["apache2-foreground"] 
