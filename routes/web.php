<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// 1. Redirect Halaman Utama ke Produk
Route::get('/', function () {
    return redirect()->route('product.index');
});

// 2. Rute Dashboard (Wajib ada biar navigasi gak error)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// 3. Rute About (Ini yang bikin kamu error barusan!)
Route::get('/about', function () {
    return view('about'); // Pastikan kamu punya file resources/views/about.blade.php
})->name('about');

// 4. Product Page (CRUD kamu)
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::post('/product', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
Route::get('/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');