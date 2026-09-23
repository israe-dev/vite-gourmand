# Application Vite & Gourmand

Projet de développement réalisé dans le cadre de l'évaluation pour l'obtention du titre professionnel de Développeur Web et Web Mobile.

## Description du Projet

Vite & Gourmand est une application web conçue pour moderniser l'activité d'une entreprise de restauration et de service traiteur. Le système permet de digitaliser la consultation de la carte, la gestion des commandes en ligne, ainsi que l'administration des menus, des stocks et des plannings pour l'équipe interne.

* Dépôt GitHub : https://github.com/israe-dev/vite-gourmand
* Application Déployée : https://vite-gourmand.fly.dev
* Suivi de projet : https://trello.com/b/o6zpNF6l

## Rôles et Gestion des Accès

L'application met en place un contrôle d'accès strict selon quatre profils :

1. Visiteur : Consultation du catalogue public, des horaires, des avis validés et du formulaire de contact.
2. Utilisateur (Client) : Inscription, authentification, gestion du profil, passage de commande avec choix des critères (date, nombre de personnes, lieu), suivi de l'avancement, modification ou annulation sous condition, et dépôt d'avis après prestation.
3. Employé : Gestion des menus, des plats, des allergènes, des horaires, traitement des commandes et modération des avis clients.
4. Administrateur : Ensemble des droits employés, gestion des comptes du personnel (création et désactivation) et accès au tableau de bord analytique.

## Environnement Technique

* Front-end : HTML5, Blade, Bootstrap 5, Tailwind CSS, JavaScript ES6+, Axios
* Back-end : PHP 8.2 (POO), Laravel 12 (architecture MVC)
* Base de données : MySQL (données relationnelles), MongoDB (données NoSQL)
* Services et API : Stripe (paiement sécurisé), Laravel Mail / Mailpit
* Outils et DevOps : Docker, Laravel Sail, Git, GitHub, Fly.io


## Installation et Lancement

Le projet peut être exécuté soit de manière classique (recommandé si vous utilisez XAMPP ou un serveur PHP local), soit via Docker.

### Option 1 : Lancement classique (XAMPP / Serveur PHP local)

1. Cloner le dépôt :
   ```bash
   git clone [https://github.com/israe-dev/vite-gourmand.git](https://github.com/israe-dev/vite-gourmand.git)
   cd vite-gourmand