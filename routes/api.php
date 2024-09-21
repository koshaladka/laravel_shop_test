<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::group(['prefix' => '/product'], function () {
        Route::post('/check', [ProductController::class, 'check']);
        Route::post('/buy', [ProductController::class, 'buy']);
        Route::post('/rent', [ProductController::class, 'rent']);
        Route::post('/rent_more', [ProductController::class, 'rentMore']);
    });


});
