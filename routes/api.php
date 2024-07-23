<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);    
    Route::post('/', [CategoryController::class, 'store']);  
    Route::get('/{id}', [CategoryController::class, 'show']); 
    Route::put('/{id}', [CategoryController::class, 'update']); 
    Route::delete('/{id}', [CategoryController::class, 'destroy']); 
});

Route::prefix('transactions')->group(function () {
    Route::get('/', [TransactionController::class, 'index']);    
    Route::post('/', [TransactionController::class, 'store']);  
    Route::get('/show', [TransactionController::class, 'show']); 
    Route::put('/{id}', [TransactionController::class, 'update']); 
    Route::delete('/{id}', [TransactionController::class, 'destroy']);
});

Route::prefix('items')->group(function () {
    Route::get('/', [ItemController::class, 'index']);    
    Route::post('/', [ItemController::class, 'store']);  
    Route::get('/{id}', [ItemController::class, 'show']); 
    Route::put('/{id}', [ItemController::class, 'update']); 
    Route::delete('/{id}', [ItemController::class, 'destroy']); 
});