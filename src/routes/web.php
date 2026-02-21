<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

/* USER */
Route::get('/', [ContactController::class, 'index'])->name('contact.index');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/thanks', [ContactController::class, 'store'])->name('contact.store');

/* ADMIN */
//Route::middleware('auth')->group(function () {
    Route::get('/admin', [AuthController::class, 'admin'])->name('contacts.index');
//});
Route::get('/search', [AuthController::class, 'search'])->name('admin.search');
Route::get('/reset', [AuthController::class, 'reset'])->name('admin.reset');
Route::get('/delete/{id}', [AuthController::class, 'show'])->name('admin.show');
Route::delete('/delete/{id}', [AuthController::class, 'destroy'])->name('admin.destroy');
Route::get('/export', [AuthController::class, 'export'])->name('admin.export');
