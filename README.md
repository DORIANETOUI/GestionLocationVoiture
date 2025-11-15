GestionLocationVoiture

Application web réalisée avec Symfony, dédiée à la gestion complète d’une agence de location de voitures.
Elle permet de gérer les clients, chauffeurs, véhicules, marques, utilisateurs, ainsi que toutes les étapes d’une location, jusqu'au téléchargement de la facture en PDF.

 Fonctionnalités principales
 
- Gestion des Clients
Ajouter, modifier, supprimer
Voir rapidement les informations d’un client

- Gestion des Chauffeurs
CRUD complet
Suivi des chauffeurs disponibles

- Gestion des Voitures
CRUD complet sur les véhicules
Gestion de la disponibilité
Gestion des caractéristiques et de la marque

 -Gestion des Marques
Création, modification et suppression des marques de voitures

- Gestion des Locations
Création d’une location
Sélection du client, du chauffeur (optionnel) et du véhicule
Gestion des dates de départ et de retour
Mise à jour automatique de la disponibilité du véhicule
Téléchargement de la facture PDF pour chaque location

- Gestion des Utilisateurs
CRUD des comptes utilisateurs
Système de connexion et déconnexion
Accès sécurisé aux différentes sections

- Facture PDF
Chaque location génère une facture téléchargeable contenant :
les informations du client
le véhicule loué
la durée de la location
le montant détaillé

- Installation

-Cloner le dépôt
git clone https://github.com/DORIANETOUI/GestionLocationVoiture

-Installer les dépendances
composer install
npm install
npm run build

-Créer la base de données
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

-Lancer le serveur Symfony
symfony serve

- Technologies utilisées
Symfony
Twig
Doctrine ORM
MySQL (ou autre SGBD selon config)
Dompdf (ou autre bibliothèque PDF)

-Accès Administrateur

Le projet est conçu de manière sécurisée : seul l’administrateur peut créer de nouveaux utilisateurs.
Les autres utilisateurs ne peuvent pas modifier la gestion des comptes.

Identifiants par défaut :

Nom d’utilisateur : Admin
Mot de passe : Doriane
Ces identifiants permettent d’accéder à l’interface d’administration complète, incluant la gestion des utilisateurs.

Licence
Libre d'utilisation et d’amélioration.
