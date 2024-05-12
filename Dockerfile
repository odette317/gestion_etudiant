# Utilisez l'image PHP officielle en tant que base
FROM php:7.2-apache

# Copiez les fichiers de votre application dans le conteneur
COPY . /var/www/html

# Exposez le port 80 pour accéder à votre application depuis l'extérieur du conteneur
#EXPOSE 80

# Commande par défaut pour exécuter votre application PHP
CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]



