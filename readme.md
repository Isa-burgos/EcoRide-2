# EcoRide

## A propos

EcoRide est une application fictive de covoiturage qui prône des valeurs écologiques.

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :
- Docker version 27.4.0 installé sur votre machine
- [Node.js](https://nodejs.org/fr) (pour les paquets npm si nécessaire),
- un SGBD comme [phpMyAdmin](https://www.phpmyadmin.net/) pour gérer votre base de données (optionnel),
- une version récente de [PHP](https://www.php.net/)
- un éditeur de code

## Technologies utilisées

- **HTML5** : structure du contenu
- **CSS3** : stylisation et mise en page
- **Bootstrap 5** : mise en page responsive
- **JavaScript** : intéractivité
- **PHP 8.2.12** : langage de programmation serveur
- **MySQL** : base de données relationnelles
- **MongoDB** : base de données non relationnelle
- **Alwaysdata** hébergeur de bases de données
- **Docker et docker-compose** : environnement de développement web
- **VScode** : éditeur de code source
- **Render** : pour l'hébergement de l'application web

## Installation

### Télécharger et extraire le projet

- sur le repository du projet EcoRide, cliquez sur le bouton "code" puis télécharger le zip
- extraire le fichier ZIP dans un répertoire de votre machine

### Importer la base de données

- Ouvrez votre outil de gestion de base de données (comme phpMyAdmin)
- Créez une nouvelle base de données pour EcoRide
- Importez la base de données en exécutant le script SQL situé dans le répertoire du projet (burgos_ecoride.sql)

### Configurer les variables d'environnement

- Créez un fichier .env à la racine de votre projet :

DB_HOST=nom-du-host-alwaysdata
DB_NAME=nom-de-la-bdd
DB_USER=utilisateur
DB_PASS=motdepasse
MONGO_URI=mongodb://mongodb:27017

### Lancez les containers

docker-compose up -d --build

### Accédez à l'application

- Interface web : http://localhost/8000 (ou le port que vous aurez configuré dans votre Docker-Compose)
- Base MongoDB (si utilisée) : connectée via le service mongodb
- MySQL accessible via Alwaysdata

## Déploiement

- Accès en ligne : https://ecoride-2-bl8z.onrender.com
- Redirection HTTPS activée automatiquement
- Les variables d'environnement sont configurées directement via le dashboard Render

## Fonctionnalités principales

- Création de compte et authentification
- Création et réservation de trajets
- Système de crédits
- Connexion à l'espace administrateur avec création de compte employé et gestion des employés et des utilisateurs (suspension, suppression)
- Suggestions d’adresses avec l’API OpenRouteService
- Géolocalisation et calcul d'itinéraire
- Interface responsive