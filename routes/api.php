<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Middleware\AdminAccessedRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductsController::class)->middleware('auth:sanctum');

Route::group(['prefix' => 'auth'], function () {
  Route::post('register', [AuthController::class, 'register']);
  Route::post('login', [AuthController::class, 'login']);
  Route::post('logout', [AuthController::class, 'logout']);
})->middleware('auth');

Route::group(['prefix' => 'admin'], function () {
  Route::post('register', [AdminAuthController::class, 'register']);
  Route::post('login', [AdminAuthController::class, 'login']);
  Route::post('logout', [AdminAuthController::class, 'logout']);
});

Route::get('hello', function () {
  return "Yep";
})->middleware(AdminAccessedRoute::class);;
