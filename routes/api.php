<?php

use App\Http\Controllers\CategoryController;
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

    // Categories Routes
    Route::controller(CategoryController::class)->group(function () {
        Route::get('categories','index');
        Route::post('category/create', 'store');
        Route::get('category/{category:uuid}', 'show');
        Route::delete('category/{category:uuid}', 'destroy');
    });
});
