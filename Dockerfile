# Use an official PHP image as the base image
FROM php:8.3-apache

# Set the working directory in the container
WORKDIR /var/www/php

# Copy the application files to the container
COPY . /var/www/php/

# Expose the port on which your application will run
EXPOSE 80

# Modify ports.conf to set ServerName
RUN sed -i.bak -e 's/Listen 80/Listen 80\nServerName localhost/' /etc/apache2/ports.conf


# Start the Apache server
CMD ["apache2-foreground"] 
