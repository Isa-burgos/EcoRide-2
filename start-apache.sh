#!/bin/bash
# Récupère le port fourni par Heroku (par défaut 80 si non défini)
PORT=${PORT:-80}

# Modifie la configuration d'Apache pour écouter sur le port Heroku
# Cela suppose que votre fichier de configuration par défaut est 000-default.conf ou similaire
# Adapter le chemin si nécessaire
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# Démarre Apache en mode foreground
apache2-foreground