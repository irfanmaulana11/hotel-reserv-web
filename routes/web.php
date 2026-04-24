<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OrderController;
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

// User profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('book.profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('book.profile.update');

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/checkout', [CartController::class, 'store'])->name('cart.store');

    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{reservation}', [OrderController::class, 'show'])->name('orders.show');
});
