<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. The Welcome Page
Route::get('/', function () {
    return view('welcome');
});

Route::get('/videos', function () {
    return view('videos-page'); // We need to make this wrapper
})->middleware(['auth', 'verified'])->name('videos');


// 2. The Dashboard (Where your Material Form lives)
// This protects the route so only logged-in users can see it.
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. User Profile Routes (Standard Laravel stuff)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. THE MISSING PIECE: This loads the Login/Register routes
require __DIR__.'/auth.php';