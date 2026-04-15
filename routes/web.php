<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class);

Route::prefix('book')->name('book.')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('index');
    Route::get('/login', [BookingController::class, 'login'])->name('login');
    Route::get('/search', [BookingController::class, 'search'])->name('search');
    Route::get('/hotel/{slug}', [BookingController::class, 'show'])->name('hotel');
    Route::get('/checkout', [BookingController::class, 'checkout'])->name('checkout');
    Route::post('/reservations', [BookingController::class, 'store'])->name('store');
    Route::get('/konfirmasi', [BookingController::class, 'confirmation'])->name('confirmation');
});
