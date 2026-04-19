<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UmkmController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/tes', function () {
    return 'Halo, project bisa jalan!';
});

// Rute untuk menampilkan halaman form import
Route::get('/admin/umkm/import', [UmkmController::class, 'showImportForm'])->name('umkm.import.form');
// Rute untuk memproses file CSV yang diupload
Route::post('/admin/umkm/import', [UmkmController::class, 'processImport'])->name('umkm.import.process');

// Rute untuk menampilkan halaman tabel UMKM
Route::get('/admin/umkm', [UmkmController::class, 'index'])->name('umkm.index');
// Rute untuk menghapus data UMKM
Route::delete('/admin/umkm/{id}', [UmkmController::class, 'destroy'])->name('umkm.destroy');

// (Persiapan) Rute untuk halaman verifikasi nanti
Route::get('/admin/umkm/{id}/verifikasi', [UmkmController::class, 'verifikasi'])->name('umkm.verifikasi');
// Route BARU untuk menyimpan/memperbarui data verifikasi
Route::put('/admin/umkm/{id}/verifikasi', [UmkmController::class, 'updateVerifikasi'])->name('umkm.updateVerifikasi');



// git add . 
// git commit -m ""
// git push -u origin main

// php artisan migrate:fresh --seed     

// klo loading lama
// di .env, SESSION_DRIVER=file
// hapus semua file di folder bootstrap-cache kecuali .gitignore