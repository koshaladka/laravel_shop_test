<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/cities', [CityController::class, 'index']);

Route::get('/users', [UserController::class, 'index']);
Route::post('/user', [UserController::class, 'store']);

