<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BerandaController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/tes', function () {
    return 'Halo, project bisa jalan!';
});

// Rute untuk menampilkan halaman form import
Route::get('/admin/import', [UmkmController::class, 'showImportForm'])->name('umkm.import.form');
// Rute untuk memproses file CSV yang diupload
Route::post('/admin/import', [UmkmController::class, 'processImport'])->name('umkm.import.process');

// Rute untuk menampilkan halaman tabel UMKM
Route::get('/admin/umkm', [UmkmController::class, 'index'])->name('umkm.index');
// Rute untuk menghapus data UMKM
Route::delete('/admin/umkm/{id}', [UmkmController::class, 'destroy'])->name('umkm.destroy');

// Rute untuk halaman verifikasi nanti
Route::get('/admin/umkm/{id}/verifikasi', [UmkmController::class, 'verifikasi'])->name('umkm.verifikasi');
// Route BARU untuk menyimpan/memperbarui data verifikasi
Route::put('/admin/umkm/{id}/verifikasi', [UmkmController::class, 'updateVerifikasi'])->name('umkm.updateVerifikasi');

// Route untuk menampilkan halaman edit
Route::get('/admin/umkm/{id}/edit', [UmkmController::class, 'edit'])->name('umkm.edit');
// Route BARU untuk menyimpan/memperbarui data hasil editan
Route::put('/admin/umkm/{id}/update', [UmkmController::class, 'update'])->name('umkm.update');

// Route tambah data manual
Route::get('/admin/tambah-umkm', [UmkmController::class, 'create'])->name('umkm.create');
Route::post('/admin/tambah-umkm', [UmkmController::class, 'store'])->name('umkm.store');

// Route daftar umkm (card)
Route::get('/admin/daftar-umkm', [DaftarController::class, 'index'])->name('umkm.daftar');

// Route tampilkan peta sebaran
Route::get('/admin/peta-sebaran', [PetaController::class, 'petaSebaran'])->name('umkm.peta');

// ROUTE KHUSUS MANAJEMEN KATEGORI 
Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::post('/admin/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::put('/admin/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

// Route untuk dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Route publik tanpa login
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
Route::get('/daftar-umkm', [BerandaController::class, 'daftar'])->name('daftar');
Route::get('/peta-sebaran', [BerandaController::class, 'peta'])->name('peta');







// git add . 
// git commit -m ""
// git push -u origin main

// php artisan migrate:fresh --seed     

// mobile = 320-430         md > 768        sm > 576
// tablet = 768-1024        lg > 992        xs < 576
// desktop = 1024-1440      xl > 1200

// klo loading lama
// di .env, SESSION_DRIVER=file
// hapus semua file di folder bootstrap-cache kecuali .gitignore


// login, public page, mobile version

// tampilan verif mobile blm                        donnnn
// marker peta ilang klo dipencet sembarang         donnnn
// btn simpan tambah data manual
// dropdown kategori dan kelurahan di halaman create, verif, edit