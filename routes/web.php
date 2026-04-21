<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\StripeController;
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

    // Stripe payment routes
    Route::post('/stripe/checkout', [StripeController::class, 'createCheckoutSession'])->name('stripe.checkout');
    Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');
});

// Stripe webhook (must be outside book prefix and allow POST)
Route::post('/stripe/webhook', [StripeController::class, 'handleWebhook'])->name('stripe.webhook');

// Google OAuth routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
