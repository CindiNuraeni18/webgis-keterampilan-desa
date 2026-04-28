<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DusunController;
use App\Http\Controllers\RwController;
use App\Http\Controllers\RtController;
use App\Http\Controllers\KategoriKeterampilanController;
use App\Http\Controllers\KeterampilanController;
use App\Http\Controllers\PemetaanController;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Auth::routes();

Route::get('/home', function () {
    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('home');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
      Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/pengaturan', [ProfileController::class, 'settings'])->name('settings');
    Route::put('/pengaturan/profile', [ProfileController::class, 'update'])->name('settings.update');
    Route::put('/pengaturan/password', [ProfileController::class, 'updatePassword'])->name('settings.password');

    Route::resource('dusun', DusunController::class);
    Route::resource('rw', RwController::class);
    Route::resource('rt', RtController::class);
    Route::resource('warga', WargaController::class);

    Route::resource('kategori-keterampilan', KategoriKeterampilanController::class);
    Route::resource('keterampilan', KeterampilanController::class);

    Route::get('/pemetaan', [PemetaanController::class, 'index'])->name('pemetaan.index');
    Route::get('/api/pemetaan', [PemetaanController::class, 'api']);
    
    Route::get('/detail/rt/{id}', [PemetaanController::class, 'detailRt'])
    ->name('pemetaan.detail.rt');
Route::get('/detail/rw/{id}', [PemetaanController::class, 'detailRw'])
    ->name('pemetaan.detail.rw');
});
