<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIK (AKSES BEBAS TANPA LOGIN)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tes', function () {
    return 'Halo, project bisa jalan!';
});

Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
Route::get('/daftar-umkm', [BerandaController::class, 'daftar'])->name('daftar');
Route::get('/peta-sebaran', [BerandaController::class, 'peta'])->name('peta');

/*
|--------------------------------------------------------------------------
| ROUTE AUTENTIKASI (LOGIN & LOGOUT)
|--------------------------------------------------------------------------
*/

// Menampilkan halaman login
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
// Memproses form login (POST)
Route::post('/admin/login', [LoginController::class, 'login']);
// Memproses logout (disarankan pakai POST untuk keamanan, tapi GET juga bisa untuk kemudahan)
Route::get('/admin/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Route untuk Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route untuk menampilkan halaman Manajemen Verifikasi UMKM & Hapus UMKM
    Route::get('/admin/umkm', [UmkmController::class, 'index'])->name('umkm.index');
    Route::delete('/admin/umkm/{id}', [UmkmController::class, 'destroy'])->name('umkm.destroy');

    // Route untuk Import CSV
    Route::get('/admin/import', [UmkmController::class, 'showImportForm'])->name('umkm.import.form');
    Route::post('/admin/import', [UmkmController::class, 'processImport'])->name('umkm.import.process');

    // Route untuk Verifikasi Data
    Route::get('/admin/umkm/{id}/verifikasi', [UmkmController::class, 'verifikasi'])->name('umkm.verifikasi');
    Route::put('/admin/umkm/{id}/verifikasi', [UmkmController::class, 'updateVerifikasi'])->name('umkm.updateVerifikasi');

    // Route untuk Edit Data
    Route::get('/admin/umkm/{id}/edit', [UmkmController::class, 'edit'])->name('umkm.edit');
    Route::put('/admin/umkm/{id}/update', [UmkmController::class, 'update'])->name('umkm.update');

    // Route Tambah Data Manual
    Route::get('/admin/tambah-umkm', [UmkmController::class, 'create'])->name('umkm.create');
    Route::post('/admin/tambah-umkm', [UmkmController::class, 'store'])->name('umkm.store');

    // Route Daftar UMKM (Card View)
    Route::get('/admin/daftar-umkm', [DaftarController::class, 'index'])->name('umkm.daftar');

    // Route Tampilkan Peta Sebaran Admin
    Route::get('/admin/peta-sebaran', [PetaController::class, 'petaSebaran'])->name('umkm.peta');

    // Route Khusus Manajemen Kategori
    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/admin/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/admin/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Route Khusus Manajemen kelurahan
    Route::get('/admin/kelurahan', [KelurahanController::class, 'index'])->name('kelurahan.index');
    Route::post('/admin/kelurahan', [KelurahanController::class, 'store'])->name('kelurahan.store');
    Route::put('/admin/kelurahan/{id}', [KelurahanController::class, 'update'])->name('kelurahan.update');
    Route::delete('/admin/kelurahan/{id}', [KelurahanController::class, 'destroy'])->name('kelurahan.destroy');
});
