# OpenPlanetsMaps

## Description
OpenPlanetsMaps est un projet regroupant et structurant des données astronomiques (images, vidéos, descriptions détaillées). Il répertorie des entrées fascinantes concernant notre système solaire, en classant ces informations par planètes et corps célestes, de manière similaire à l'API APOD (Astronomy Picture of the Day) de la NASA.

## Contexte et Hébergement
Ce projet a été réalisé dans le cadre d'un examen présidé par **F. LEFEVRE**.  
Il est hébergé et accessible en ligne à l'adresse suivante : [opm.nhkyllian.fr](https://opm.nhkyllian.fr)

## Structure de la base de données

Le cœur du projet repose sur une base de données MySQL/MariaDB nommée `OpenPlanetsMaps`. Elle contient des tables dédiées pour chaque astre majeur, permettant d'isoler et de structurer les données (`id`, `date`, `title`, `explanation`, `url`, `media_type`, etc.) :

- `EARTH` (Terre)
- `JUPITER`
- `MARS`
- `MERCURY` (Mercure)
- `MOON` (Lune)
- `NEPTUNE`
- `SATURN` (Saturne)
- `SUN` (Soleil)
- `URANUS`
- `VENUS`

Le système intègre également une table `CONTACT` destinée à stocker les messages et demandes issues d'un éventuel formulaire de contact (email, objet, demande, fichier joint).

## Installation et Configuration

Pour mettre en place la base de données localement (par exemple, avec XAMPP, WAMP ou directement via MariaDB/MySQL) :

1. Créez une nouvelle base de données appelée `OpenPlanetsMaps` (encodage recommandé : `utf8mb4_general_ci`).
2. Importez le fichier de structure pour initialiser les tables :
   ```bash
   mysql -u utilisateur -p OpenPlanetsMaps < SRC/DATA/Structure.sql
   ```
3. Importez ensuite le fichier de données pour populer la base (contient actuellement les données de la Terre) :
   ```bash
   mysql -u utilisateur -p OpenPlanetsMaps < SRC/DATA/DATA.sql
   ```

## Technologies
- Base de données : MySQL / MariaDB (généré via phpMyAdmin)