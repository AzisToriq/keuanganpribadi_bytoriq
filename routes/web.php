<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserProfileController; // Assuming you have a controller for the profile page

// Halaman landing (public)
Route::view('/', 'welcome');

// Protected routes (hanya untuk user yang login & verified)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // User Profile Route from Jetstream
    // This route will render the view for the user profile page.
    // The view is typically resources/views/profile/show.blade.php
    Route::get('/user/profile', function () {
        return view('profile.show');
    })->name('profile.show');

    // Export PDF transaksi
    Route::get('/transactions/export/pdf', [TransactionController::class, 'exportPdf'])
        ->name('transactions.export.pdf');

    // CRUD Kategori & Transaksi
    Route::resource('categories', CategoryController::class);
    Route::resource('transactions', TransactionController::class);

    // NOTE: Fortify handles the backend logic for profile updates automatically.
    // The route 'profile.updateProfileInformation' that caused the error is
    // registered internally by Fortify when its features are enabled.
    // By having the `profile.show` route, your forms will now work correctly.
});
