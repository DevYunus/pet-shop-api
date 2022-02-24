<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {

    Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('logout',
            [App\Http\Controllers\AuthController::class, 'logout']);

        // Category Routes
        Route::controller(CategoryController::class)->group(function () {
            Route::get('categories', 'index');
            Route::post('category/create', 'store')->middleware('admin');
            Route::get('category/{category:uuid}', 'show');
            Route::delete('category/{category:uuid}', 'destroy')->middleware('admin');
        });

        // Product Routes
        Route::controller(ProductController::class)->group(function () {
            Route::get('products', 'index');
            Route::post('product/create', 'store')->middleware('admin');
            Route::put('product/{product:uuid}', 'update')->middleware('admin');
            Route::get('product/{product:uuid}', 'show');
            Route::delete('product/{product:uuid}', 'destroy')->middleware('admin');
        });

        //Order routes
        Route::controller(OrderController::class)->group(function () {
            Route::get('orders', 'index');
            Route::post('order/create', 'store');
            Route::put('order/{order:uuid}', 'update');
            Route::get('order/{order:uuid}', 'show');
            Route::delete('order/{order:uuid}', 'destroy');
        });

        //User routes
        Route::controller(UserController::class)->group(function () {
            Route::get('user/orders', 'userOrders');
            Route::get('user/{user:uuid}', 'show');
            Route::delete('user/{user:uuid}', 'destroy');
        });

        //Admin routes
        Route::controller(AdminController::class)->group(function () {
            Route::get('admin/user-listing', 'index');
            Route::delete('user-delete/{user:uuid}', 'destroy');
        });
    });
});

