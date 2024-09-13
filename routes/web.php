<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\ArticleController::class, 'indexToHome']);
Route::get('/login', [App\Http\Controllers\AuthController::class, 'loginShow'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::group(['middleware' => 'auth'], function() {
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::resource('/users', App\Http\Controllers\UserController::class)->except(['show']);
    Route::resource('/reports', App\Http\Controllers\ReportController::class);
    Route::resource('/articles', App\Http\Controllers\ArticleController::class);
});
