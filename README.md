# Pet Shop API

- Built on top of Laravel 9
- Used Laravel Sanctum for Authentication
-  Explore API's: [Posman Collection](https://github.com/DevYunus/pet-shop-api/blob/master/petshop.postman_collection.json)

## How to run app

- Copy Environment file and update database config.
  `cp .env.example .env`

- Install dependencies
  `composer install`

- `php artisan key:generate`
- `php artisan migrate --seed`
