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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BackupController; 
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PesanController;



Route::get('/', [LandingPageController::class, 'index'])
    ->name('landing');

Route::post('/kirim-pesan', [PesanController::class, 'store'])
    ->name('pesan.store');

Auth::routes();

Route::get('/home', function () {
    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('home');

 Route::get('/api/pemetaan', [PemetaanController::class, 'api']);
 
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
      Route::get('/dashboard', [HomeController::class, 'index'])
    ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/pengaturan', [ProfileController::class, 'settings'])->name('settings');
    Route::put('/pengaturan/profile', [ProfileController::class, 'update'])->name('settings.update');
    Route::put('/pengaturan/password', [ProfileController::class, 'updatePassword'])->name('settings.password');

    Route::resource('dusun', DusunController::class);
    Route::resource('rw', RwController::class);
    Route::resource('rt', RtController::class);
    Route::resource('warga', WargaController::class);
Route::post(
    '/warga/import',
    [WargaController::class, 'import']
)->name('warga.import');
    Route::resource('kategori-keterampilan', KategoriKeterampilanController::class);

    Route::get(
    '/keterampilan/statistik',
    [KeterampilanController::class, 'statistik']
)->name('keterampilan.statistik');

Route::get(
    '/keterampilan/laporan',
    [KeterampilanController::class, 'laporan']
)->name('keterampilan.laporan');

Route::get(
    '/keterampilan/laporan/pdf',
    [KeterampilanController::class, 'exportPdf']
)->name('keterampilan.laporan.pdf');

Route::get(
    '/keterampilan/laporan/excel',
    [KeterampilanController::class, 'exportExcel']
)->name('keterampilan.laporan.excel');

    Route::resource('keterampilan', KeterampilanController::class);

    Route::get('/pemetaan', [PemetaanController::class, 'index'])->name('pemetaan.index');
    Route::get('/detail/rt/{id}', [PemetaanController::class, 'detailRt'])
    ->name('pemetaan.detail.rt');
Route::get('/detail/rw/{id}', [PemetaanController::class, 'detailRw'])
    ->name('pemetaan.detail.rw');
Route::get(
    '/detail/dusun/{id}',
    [PemetaanController::class,'detailDusun']
)->name('pemetaan.detail.dusun');

    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
Route::post('/backup', [BackupController::class, 'store'])->name('backup.store');
Route::get('/backup/download/{id}', [BackupController::class, 'download'])->name('backup.download');

Route::get('/pesan', [PesanController::class, 'index'])
    ->name('pesan.index');

Route::put('/pesan/{id}/setujui',
    [PesanController::class, 'setujui'])
    ->name('pesan.setujui');

Route::put('/pesan/{id}/tolak',
    [PesanController::class, 'tolak'])
    ->name('pesan.tolak');
});
