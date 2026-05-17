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


## Technologies
- Database: MySQL / MariaDB (generated via phpMyAdmin)
- Frontend: HTML, CSS, JavaScript
- Packaging: Electron Packager
- CI/CD: GitHub Actions
- Data format: JSON

## Releases (Mobile Apps)
Native mobile applications for this project are now available. You can download them directly from the **Releases** tab of this GitHub repository:
- **Android**: Download the `.apk` file to install the app on your Android device.
- **iOS**: Download the `.ipa` file to install the app on your iOS device.

## Data Source & License
The astronomical data (images, videos, and descriptions) provided in this project is sourced from the public NASA API. 
As per NASA's media guidelines, these materials are in the **public domain** and are completely free to use without any royalties.

The code and structure of this project are open-source and entirely free to use.