<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group (which should be configured for Passport).
|
*/

Route::get('brands/toplist', [BrandController::class, 'topList']);
Route::get('brands/{id}', [BrandController::class, 'show']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    // Brand Management Routes
    Route::apiResource('brands', BrandController::class)->except(['show']);

    // User Session Management
    Route::post('logout', [UserController::class, 'logout']);

});