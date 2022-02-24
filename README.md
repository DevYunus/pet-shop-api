# Pet Shop API 

> This is tiny laravel app which is built to showcase how I usually code. Ofcourse it doesnt have any major features which comes in handy to scale up the app like Queue, Caching, Modular structure, Broadcasting etc

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

## For Code Reviewer
Here are few files which demonstrate few important features which might interest you. 

 - Controller - 
 [CategoryController](https://github.com/DevYunus/pet-shop-api/blob/master/app/Http/Controllers/CategoryController.php)
 [OrderController](https://github.com/DevYunus/pet-shop-api/blob/master/app/Http/Controllers/OrderController.php)

- Authentication- [AuthController](https://github.com/DevYunus/pet-shop-api/blob/master/app/Http/Controllers/AuthController.php)

- Policy - [OrderPolicy](https://github.com/DevYunus/pet-shop-api/blob/master/app/Policies/OrderPolicy.php)
- Middleware - [Admin Middleware](https://github.com/DevYunus/pet-shop-api/blob/master/app/Http/Middleware/MustBeAdmin.php)

Feel free to reachout to me at  Yunus.shaikh0493@gmail.com