<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/profile', function () {
    // Only authenticated users may access this route...
    return "hello";
})->middleware('auth.basic');

Route::get('/test', function () {
    $user = User::find(5);
    return $user->products;
});
