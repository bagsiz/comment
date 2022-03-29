
## About Project

This project's goal is to post nested comments, 3 layers deep, and display them in order.

## Installation

````shell
cp .env.example .env
````
And edit .env file accordingly.

Then;

```shell
composer install
php artisan migrate
php artisan db:seed
```

Then route to root ('/') and post comments.

If you'd like to test;

````shell
./vendor/bin/phpunit --coverage-html build/
````
