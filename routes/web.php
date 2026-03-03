<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman depan
Route::get('/', function () {
    return view('welcome');
});

// Semua rute yang butuh login
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Rute Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // RUTE ABOUT (Ini yang dicari sistem)
    Route::get('/about', function () {
        return view('about');
    })->name('about');

    // Rute Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';