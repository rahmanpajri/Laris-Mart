<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('welcome');
})->name('dashboard');

Route::resource('/items', App\Http\Controllers\ItemController::class);
Route::resource('/transactions', App\Http\Controllers\TransactionController::class);
Route::resource('/categories', App\Http\Controllers\CategoryController::class);