💊 MedFinder

MedFinder est une application web qui met en relation des patients à la recherche de médicaments rares avec des pharmacies disposant de ces médicaments en stock.

Elle répond au problème croissant des pénuries de médicaments en proposant une plateforme centralisée pour consulter la disponibilité des traitements et faciliter leur accès.

📌 Fonctionnalités

🏠 Page d’accueil publique
Présentation de la plateforme, FAQ et informations de contact

💊 Offres de médicaments
Liste des médicaments disponibles (nom, prix, quantité) avec possibilité de réservation

🔍 Demandes de médicaments
Les patients publient leurs recherches, les pharmacies peuvent y répondre

👤 Inscription
Deux types de comptes :

Patient

Pharmacie

🔐 Connexion / Déconnexion
Authentification via email et mot de passe avec gestion de session PHP
Redirection automatique vers le tableau de bord selon le profil

🛠️ Stack technique
Couche	Technologie
Frontend	HTML5, CSS3, Bootstrap 5, Bootstrap Icons, jQuery
Backend	PHP
Base de données	MySQL
Serveur local	XAMPP / WAMP (Apache + MySQL)
📁 Structure du projet
medfinder/
├── index.php
├── login.php
├── log.php
├── logout.php
├── register.php
├── register-patient.php
├── register-medecin.php
├── home-medicine-offers.php
├── home-medicine-requests.php
├── contact.html
├── withlogin/
│   ├── patient/
│   └── pharmacy/
├── css/
├── js/
├── fonts/
└── images/
🗄️ Base de données

Le projet utilise une base de données MySQL nommée medfinder.

Tables principales :
Table	Description
patient	Informations des patients
pharmacie	Comptes des pharmacies
medicament	Catalogue des médicaments
proposer	Stock des pharmacies (quantité disponible)
recherche	Demandes des patients
⚙️ Installation et lancement
📋 Prérequis

XAMPP ou WAMP

PHP 7.4+

MySQL 5.7+

🚀 Étapes

Copier le projet dans :

C:/xampp/htdocs/medfinder/

Démarrer Apache et MySQL

Créer la base de données :

Ouvrir phpMyAdmin

Créer medfinder

Importer le fichier .sql (si disponible)

Accéder à l’application :

http://localhost/medfinder/
⚠️ Configuration

Par défaut :

Host : localhost

User : root

Password : (vide)

Si nécessaire, modifier dans :

log.php

home-medicine-offers.php

home-medicine-requests.php

register-patient.php

register-medecin.php

🚧 Améliorations possibles

🔒 Hachage des mots de passe (password_hash())

🛡️ Sécurisation contre les injections SQL (requêtes préparées)

📦 Fournir un fichier .sql d’initialisation

🌍 Internationalisation (FR / AR / EN)

🔔 Système de notifications (disponibilité des médicaments)

📞 Contact

📍 Casablanca, Maroc
📞 0566918912
📧 infocompany@MEDFINDER.com

⭐ À propos

Ce projet vise à améliorer l’accès aux médicaments en facilitant la communication entre patients et pharmacies grâce à une solution digitale simple et efficace.
