<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);    // Menampilkan semua kategori
    Route::post('/', [CategoryController::class, 'store']);   // Menambahkan kategori baru
    Route::get('/{id}', [CategoryController::class, 'show']); // Menampilkan kategori berdasarkan ID
    Route::put('/{id}', [CategoryController::class, 'update']); // Mengupdate kategori berdasarkan ID
    Route::delete('/{id}', [CategoryController::class, 'destroy']); // Menghapus kategori berdasarkan ID
});
