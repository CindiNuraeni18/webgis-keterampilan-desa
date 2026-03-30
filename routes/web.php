<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Auth::routes();

Route::get('/home', function () {
    return redirect()->route('admin.profile');
})->middleware('auth')->name('home');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::get('/pengaturan', [ProfileController::class, 'settings'])->name('admin.settings');
    Route::put('/pengaturan/profile', [ProfileController::class, 'update'])->name('admin.settings.update');
    Route::put('/pengaturan/password', [ProfileController::class, 'updatePassword'])->name('admin.settings.password');
});