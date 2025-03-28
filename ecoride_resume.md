# 🛠️ Récapitulatif du projet EcoRide

## 📦 Stack technique

### Frontend
- HTML / CSS / JavaScript
- Bootstrap supprimé au profit de Tailwind (en réflexion)
- Icônes SVG personnalisées

### Backend
- PHP 8.3 avec Apache
- Docker (multi-services)
- MySQL pour les données relationnelles
- MongoDB pour les préférences non relationnelles

### Frameworks & outils
- Architecture MVC maison
- Composer
- PDO pour MySQL
- MongoDB via extension PHP + bibliothèque `mongodb/mongodb`
- Apache VirtualHost personnalisé (ecoride.conf)
- Formulaires natifs avec gestion `$_POST`, `$_SESSION`, etc.
- Debug via `var_dump`, `log`, et `error_reporting`

---

## ✅ Fonctionnalités réalisées

### ✅ Compte utilisateur
- Connexion, inscription, déconnexion
- Affichage des infos du compte
- Formulaire de mise à jour avec validation
- Upload de photo de profil (à venir)

### ✅ Véhicules
- Ajout, édition, suppression
- Contrôle : un conducteur doit avoir au moins un véhicule
- Message de confirmation/succès/erreur via `$_SESSION`

### ✅ Suppression
- Interdiction de suppression si le véhicule est lié à un trajet
- Messages flash (`success`, `errors`) avec alertes Bootstrap

---

## ⚙️ Intégration MongoDB

### Objectif
Stocker des préférences flexibles par véhicule :
- Fumeur : oui/non
- Animaux autorisés : oui/non
- Autres préférences personnalisées (texte libre)

### Mise en place
- Service MongoDB dans `docker-compose.yml`
- Port 8090 exposé
- Identifiants configurés (`MONGO_INITDB_ROOT_USERNAME` etc.)
- MongoDB Compass connecté à la base `ecoride` et à la collection `preferences`
- Extension PHP MongoDB installée via `pecl`
- Paquet `mongodb/mongodb` installé via Composer dans le conteneur PHP

---

## 📂 Structure Docker

```yaml
# docker-compose.yml
services:
  php:
    build:
      context: .
      dockerfile: Dockerfile
    ports:
      - "8080:80"
    volumes:
      - .:/var/www/html
    depends_on:
      - mongodb

  mongodb:
    image: mongo:7.0
    ports:
      - "8090:27017"
    environment:
      MONGO_INITDB_ROOT_USERNAME: mongo_ecoride
      MONGO_INITDB_ROOT_PASSWORD: Is@bel1410
