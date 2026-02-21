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

Route::get('/contacts/{id}', [AuthController::class, 'show'])->name('contacts.show');
Route::delete('/contacts/{id}', [AuthController::class, 'destroy'])->name('contacts.destroy');