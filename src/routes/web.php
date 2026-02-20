<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

/* USER */
Route::get('/', [ContactController::class, 'index']);
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/thanks', [ContactController::class, 'store']);

/* ADMIN */
//Route::middleware('auth')->group(function () {
    Route::get('/admin', [AuthController::class, 'admin']);
//});