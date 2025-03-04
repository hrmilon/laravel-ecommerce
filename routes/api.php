<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Middleware\AuthCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductsController::class)->except('index')->middleware('auth:sanctum');
Route::get('products', [ProductsController::class, 'index']);

Route::group(['prefix' => 'admin'], function () {
  // Route::apiResource('r', AdminController::class);
  Route::get('pending', [AdminController::class, 'pendingProducts']);
  Route::post('approve/{id}', [AdminController::class, 'approval'])->name('admin.approve');
});

//authentication for seller(User), Customer, Admin
Route::group(['prefix' => 'auth'], function () {

  Route::group(['prefix' => 'seller'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
  });

  Route::group(['prefix' => 'customer'], function () {
    Route::post('register', [CustomerAuthController::class, 'register']);
    Route::post('login', [CustomerAuthController::class, 'login']);
    Route::post('logout', [CustomerAuthController::class, 'logout']);
  });

  Route::group(['prefix' => 'admin'], function () {
    Route::post('register', [AdminAuthController::class, 'register']);
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout']);
  });
});


Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');
