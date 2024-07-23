<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::resource('/items', App\Http\Controllers\ItemController::class)->except(['show']);
Route::resource('/transactions', App\Http\Controllers\TransactionController::class);
Route::resource('/categories', App\Http\Controllers\CategoryController::class);

Route::get('/items/compare-sales', [ItemController::class, 'compareSales'])->name('items.compare-sales');
Route::get('/dashboard', [TransactionController::class, 'show'])->name('dashboard');