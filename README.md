# OpenPlanetsMaps

## Description
OpenPlanetsMaps is a project that gathers and structures astronomical data (images, videos, detailed descriptions). It lists fascinating entries about our solar system, categorizing this information by planets and celestial bodies, similar to NASA's APOD (Astronomy Picture of the Day) API.

## Context and Hosting
This project was carried out as part of an exam presided over by **F. LEFEVRE**.  
It is hosted and accessible online at the following address: [opm.nhkyllian.fr](https://opm.nhkyllian.fr)  
Secondary URL: [openplanetsmaps.alwaysdata.net](http://openplanetsmaps.alwaysdata.net)

## Database Structure

The core of the project relies on a MySQL/MariaDB database named `OpenPlanetsMaps`. It contains dedicated tables for each major celestial body, allowing data to be isolated and structured (`id`, `date`, `title`, `explanation`, `url`, `media_type`, etc.):

- `EARTH`
- `JUPITER`
- `MARS`
- `MERCURY`
- `MOON`
- `NEPTUNE`
- `SATURN`
- `SUN`
- `URANUS`
- `VENUS`

The system also includes a `CONTACT` table intended to store messages and requests from a potential contact form (email, subject, request, attached file).

## Installation and Configuration

To set up the database locally (for example, with XAMPP, WAMP, or directly via MariaDB/MySQL):

1. Create a new database named `OpenPlanetsMaps` (recommended encoding: `utf8mb4_general_ci`).
2. Import the structure file to initialize the tables:
   ```bash
   mysql -u user -p OpenPlanetsMaps < SRC/DATA/Structure.sql
   ```
3. Then import the data file to populate the database (currently contains Earth data):
   ```bash
   mysql -u user -p OpenPlanetsMaps < SRC/DATA/DATA.sql
   ```

## Technologies
- Database: MySQL / MariaDB (generated via phpMyAdmin)

## Releases (Mobile Apps)
Native mobile applications for this project are now available. You can download them directly from the **Releases** tab of this GitHub repository:
- **Android**: Download the `.apk` file to install the app on your Android device.
- **iOS**: Download the `.ipa` file to install the app on your iOS device.