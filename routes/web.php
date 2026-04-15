<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UmkmController;

Route::get('/', function () {
    return view('welcome');
});

// Rute untuk menampilkan halaman form import
Route::get('/admin/umkm/import', [UmkmController::class, 'showImportForm'])->name('umkm.import.form');

// Rute untuk memproses file CSV yang diupload
Route::post('/admin/umkm/import', [UmkmController::class, 'processImport'])->name('umkm.import.process');

// git add . 
// git commit -m ""
// git push -u origin main