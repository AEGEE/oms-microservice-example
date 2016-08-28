# OMS Microservice example
Based on PHP Lumen

This module is made as proof of concept of how a microservice will work with the core. It contains the basic features a microservice can use (and some should use) with the core.

## Current features
* Registration with the core
* Display frontend via core
* Uses core feature to get the logged in user's data. 

## Installation (considering you already have the core installed and accessible)
1. Clone repository
2. Point webserver to *public* folder inside
3. Copy / Rename .env.example file as .env
4. Edit the desired parameters in the .env file
5. In command line in the repository root directory, run the commands
⋅⋅1. "composer install"
⋅⋅2. "php artisan migrate"
6. Point your browser to the url: <microservice_url>/register
7. The microservice should be visible as "disabled" in the core > modules page