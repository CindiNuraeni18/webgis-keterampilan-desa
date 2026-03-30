<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Landing Page (Guest Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('landing');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| After Login (Authenticated Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Home setelah login
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Admin section
    Route::prefix('admin')->group(function () {

        Route::get('/profile', [ProfileController::class, 'index'])
            ->name('admin.profile');

        Route::put('/profile', [ProfileController::class, 'update'])
            ->name('admin.profile.update');

        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
            ->name('admin.profile.password');
    });
});