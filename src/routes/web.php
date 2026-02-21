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
    Route::get('/admin', [AuthController::class, 'admin'])->name('contacts.index');
//});
Route::get('/search', [AuthController::class, 'search'])->name('contacts.search');
Route::get('/reset', [AuthController::class, 'reset'])->name('contacts.reset');
Route::get('/delete/{id}', [AuthController::class, 'show'])->name('contacts.show');
Route::delete('/delete/{id}', [AuthController::class, 'destroy'])->name('contacts.destroy');
