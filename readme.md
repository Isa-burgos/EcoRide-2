# 🚗 EcoRide – Plateforme de covoiturage écologique

Bienvenue sur **EcoRide**, une application web en PHP orientée objet permettant aux utilisateurs de proposer ou réserver des trajets en covoiturage avec un système de crédits, de rôles, et de gestion de véhicules 🚙⚡

---

## 🧱 Stack technique

- **Langage** : PHP (POO)
- **Architecture** : MVC (Models, Views, Controllers)
- **Base de données** : MySQL / MariaDB
- **Front-end** : Bootstrap 5, CSS personnalisé, JavaScript vanilla
- **Gestion des routes** : Router personnalisé (type mini-framework)
- **Images & Uploads** : Upload photo profil dans `upload/`
- **Données externes** : API OpenDataSoft (marques et modèles de véhicules)

---

## 🔐 Authentification

- Création de compte avec mot de passe sécurisé (`password_hash`)
- Connexion avec vérification via `password_verify`
- Session utilisateur contenant : `id`, `email`, `pseudo`, `photo`
- Affichage conditionnel dans la navbar (pseudo + photo)

---

## 👤 Utilisateurs

- Ont un rôle via une table `statut` :
  - `Passager`
  - `Conducteur`
  - ou les deux
- Rôle enregistré dans table pivot `user_statut`
- Reçoivent 20 crédits à la création du compte

---

## 🚗 Véhicules

- Liés à l’utilisateur via `belong` dans la table `vehicle`
- Un conducteur peut avoir **plusieurs véhicules**
- Champs à renseigner :
  - Marque / Modèle (chargés dynamiquement via API)
  - Couleur
  - Énergie (électrique ou non)
  - Plaque d’immatriculation
  - Date de 1ère immatriculation
- Icône spéciale si véhicule électrique ✅

---

## 📝 Formulaire compte utilisateur

- Modification des infos perso
- Gestion des statuts (passager / conducteur)
- Section véhicule visible uniquement si "conducteur" coché
- Permet d’ajouter un nouveau véhicule si souhaité
- Validation côté PHP et JS

---

## ✅ Comportements gérés

- Si "conducteur" est coché → au moins un véhicule requis
- Si un véhicule existe déjà → pas d’obligation d’en ajouter un nouveau
- Formulaire dynamique avec apparition progressive des champs véhicule
- Affichage d’un message de confirmation ou d’erreur après mise à jour
- Upload image de profil avec fallback vers image par défaut

---

## 💡 Astuces dev

- ⚠️ Le champ `required` ne fonctionne pas si le champ est masqué (`display: none`) → on utilise JS pour ajouter/enlever dynamiquement l’attribut `required`.
- `renderPartial('alert')` permet de centraliser l’affichage des erreurs ou messages (partials réutilisables)
- Les routes sont toutes déclarées dans `index.php` via une classe `Router`

---

## 🔜 Fonctionnalités à venir

- Participation à un covoiturage
- Validation des trajets terminés
- Avis utilisateurs
- Tableau de bord administrateur & employé
- Statistiques admin (crédits / trajets / utilisateurs)

---



