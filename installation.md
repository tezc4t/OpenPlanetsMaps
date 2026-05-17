# Environnement de Déploiement : AlwaysData

Ce document explique la façon dont j'ai déployé et configuré le projet OpenPlanetsMaps sur mon espace d'hébergement AlwaysData.

## 1. Hébergement et Transfert de fichiers (FTP)
Le site est configuré en tant que site **PHP (version 8.x)** sur AlwaysData.
Pour la mise en ligne, j'ai utilisé le client FTP **FileZilla**. J'ai transféré l'intégralité du contenu de mon dossier local `www/` vers le répertoire racine web de mon serveur AlwaysData à l'aide des accès FTP fournis par l'hébergeur.

## 2. Base de données
L'API et le site s'appuient sur une base de données MySQL/MariaDB hébergée sur AlwaysData.
- J'ai créé la base de données directement depuis le panel AlwaysData.
- J'ai ensuite utilisé l'outil **phpMyAdmin** fourni par l'hébergeur pour importer le script de structure `doc/Structure.sql`, ce qui a généré toutes les tables nécessaires (`EARTH`, `MARS`, ..., `CONTACT`).
- J'ai également importé le fichier `data.sql` via phpMyAdmin afin de peupler la base avec les données astronomiques de chaque planètes. 

## 3. Configuration et Variables d'environnement
Pour des raisons de sécurité, les identifiants de la base de données ne sont pas codés en dur dans mes scripts publics. J'ai créé un fichier de configuration `config.php` directement sur le serveur distant, à la racine du site (`www/config.php`).

Ce fichier (non versionné sur GitHub) contient mes variables de production :

le fichier vous sera montré lors de la présentation.

## 4. Vérification finale
Une fois le déploiement terminé, j'ai effectué une série de tests sur ma version finale en production pour m'assurer que tout fonctionnait correctement :
- Accès à l'URL de mon site (ex: `https://openplanetsmaps.alwaysdata.net`).
- Vérification du bon affichage des données des planètes provenant de l'API.
- Test du formulaire de contact (l'insertion en base de données et le téléversement de fichiers sont opérationnels).
- Connexion à la page `/admin.php` avec mes identifiants pour tester l'ajout d'une entrée.
- Test du versionnage téléphone du site pour garantir une bonne adaptabilité sur mobile.
- Vérification minutieuse de l'ensemble du backlog fourni pour m'assurer de la totale conformité du livrable vis-à-vis des attentes de l'examen.

La version finale actuellement en ligne est parfaitement fonctionnelle.
