<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Resources\ProductCollection;
use Illuminate\Http\Request;
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

Route::post('admin/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('admin/logout', [App\Http\Controllers\AuthController::class, 'logout']);

    // Category Routes
    Route::controller(CategoryController::class)->group(function () {
        Route::get('categories','index');
        Route::post('category/create', 'store');
        Route::get('category/{category:uuid}', 'show');
        Route::delete('category/{category:uuid}', 'destroy');
    });

    // Product Routes
    Route::controller(ProductController::class)->group(function () {
        Route::get('products','index');
        Route::post('product/create', 'store');
        Route::put('product/{product:uuid}', 'update');
        Route::get('product/{product:uuid}', 'show');
        Route::delete('product/{product:uuid}', 'destroy');
    });

    //Order routes
    Route::controller(OrderController::class)->group(function () {
        Route::get('orders','index');
        Route::post('order/create', 'store');
        Route::put('order/{order:uuid}', 'update');
        Route::get('order/{order:uuid}', 'show');
        Route::delete('order/{order:uuid}', 'destroy');
    });
});
