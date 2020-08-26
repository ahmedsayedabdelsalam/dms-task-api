## About Project

APIs to import and list large data from xlsx file of user to database and conditionally marking them as accepted or rejected.

## Setup

- cp .env.example .env
- edit the .env file (add your DB credentials and make sure to change the queue driver to redis)
- composer install
- php artisan migrate
- php artisan queue:listen --tries=3


