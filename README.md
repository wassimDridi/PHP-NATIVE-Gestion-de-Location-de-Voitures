Gestion de Location de Voitures
Description du Projet
Ce projet a pour objectif de développer un système de gestion de location de voitures en utilisant PHP, MySQL et HTML5/CSS3. L'application permet la gestion des véhicules, des clients, des réservations et des locations, ainsi que l'affichage de l'historique des locations.

Fonctionnalités
1. Gestion des Véhicules
Ajouter un véhicule : Permet d'ajouter des informations sur les véhicules disponibles (marque, modèle, année, prix par jour).
Modifier un véhicule : Permet de mettre à jour les informations sur les véhicules existants.
Supprimer un véhicule : Permet de supprimer un véhicule de la base de données.
Afficher les véhicules : Affiche une liste détaillée des véhicules disponibles.
2. Gestion des Clients
Enregistrer un nouveau client : Permet d'ajouter un nouveau client avec des informations telles que le nom, l'adresse, le numéro de téléphone et l'email.
Afficher les clients : Affiche une liste des clients enregistrés avec leurs détails.
3. Réservations et Locations
Réserver un véhicule : Permet aux clients de réserver un véhicule pour une période spécifique.
Enregistrer une location : Enregistre les locations avec des détails tels que la date de début, la date de fin et le coût total.
Calcul automatique du coût : Calcule automatiquement le coût de la location en fonction de la durée.
4. Historique des Locations
Historique par véhicule : Affiche l'historique des locations pour chaque véhicule.
Historique par client : Affiche l'historique des locations pour chaque client.
5. Interface Utilisateur
Recherche de véhicules : Permet aux clients de rechercher des véhicules disponibles.
Demande de réservation : Permet aux clients de soumettre des demandes de réservation.
Contraintes Techniques
PHP Orienté Objet : Utilisation de PHP avec une approche orientée objet.
Base de Données MySQL : Utilisation de MySQL pour stocker les informations.
Séparation du Code en Classes : Utilisation de classes pour structurer le code (par exemple, une classe pour les véhicules, une classe pour les clients, etc.).
Requêtes SQL : Utilisation de requêtes SQL pour interagir avec la base de données.
Validation des Données : Validation des données utilisateur pour garantir la sécurité.
Bonus (Facultatif)
Notification par E-mail : Système de notification par e-mail pour les confirmations de réservation et les rappels de retour de véhicule.
Génération de Factures : Génération de factures pour les locations.
Filtrage des Véhicules : Filtrage des véhicules par catégorie (berline, SUV, utilitaire, etc.).
Modèle Relationnel de la Base de Données
Véhicules (ID_Vehicule, Marque, Modele, Annee, PrixParJour)
Clients (ID_Client, Nom, Prenom, Adresse, NumeroTelephone, Email)
Locations (ID_Location, ID_Client, ID_Vehicule, DateDebut, DateFin, PrixTotal)
Installation
Clonez le dépôt :
bash
Copier le code
git clone https://github.com/wassimDridi/PHP-NATIVE-Gestion-de-Location-de-Voitures
Accédez au répertoire du projet :
bash
Copier le code
cd gestion-location-voitures
Configurez la base de données MySQL :
Créez une base de données.
Importez le fichier database.sql pour créer les tables nécessaires.
Configurez les paramètres de connexion à la base de données dans le fichier config.php.
Lancez le serveur PHP :
bash
Copier le code
php -S localhost:8000
Accédez à l'application via votre navigateur à l'adresse http://localhost:8000.
Utilisation
Utilisez l'interface utilisateur pour ajouter, modifier et supprimer des véhicules.
Enregistrez de nouveaux clients et gérez leurs informations.
Réservez des véhicules et gérez les locations.
Consultez l'historique des locations pour chaque véhicule et chaque client.
Contribution
Les contributions sont les bienvenues ! Veuillez soumettre une pull request ou ouvrir une issue pour discuter des modifications que vous souhaitez apporter.

Licence
Ce projet est sous licence MIT. Veuillez consulter le fichier LICENSE pour plus de détails.

Auteurs
Dridi Wassim © 2023