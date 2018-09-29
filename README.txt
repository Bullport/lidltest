 
1. Create a docker environment using Docker-compose:
    docker-compose up -d

2. Log into PHP-FPM container:
    docker-compose exec php-fpm bash

[OPTIONAL but fully functional]
2.1. Create own .env file and add database credentials:
        DATABASE_URL=mysql://lidluser:lidlpass@mariadb:3306/lidltest
2.2. Create database schema within PHP-FPM container by
        php bin/console doctrine:schema:create
2.3. Load the fixtures within PHP-FPM container by
        php bin/console doctine:fixtures:load


3. Run UnitTests within PHP-FPM container by
    php bin/phpunit

4. Call Michi
