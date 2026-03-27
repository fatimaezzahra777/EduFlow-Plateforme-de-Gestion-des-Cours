<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PaymentController;


Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });

});

Route::middleware('auth:api')->group(function () {
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::put('/courses/{id}', [CourseController::class, 'update']);
    Route::delete('/courses/{id}', [CourseController::class, 'destroy']);

});

Route::middleware('auth:api')->group(function () {

    Route::get('/favoris', [FavoriteController::class, 'index']);
    Route::post('/favoris', [FavoriteController::class, 'store']);
    Route::delete('/favoris/{id}', [FavoriteController::class, 'destroy']);

});

Route::middleware('auth:api')->group(function () {

    Route::post('/inscri', [InscriptionController::class, 'inscri']);

});

Route::middleware('auth:api')->group(function () {

    Route::post('/payment/checkout', [PaymentController::class, 'checkout']);

});

Route::middleware('auth:api')->group(function () {

    Route::get('/courses/{courseId}/groups', [GroupController::class, 'index']);

});
