<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Kelurahan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
  // Menampilkan halaman beranda
  public function index()
  {
    // 1. Data untuk Insight Cards (Hanya UMKM yang disetujui)
    $totalUmkm = Umkm::where('status_verif', 'disetujui')->count();
    $totalKelurahan = Kelurahan::count();
    $totalKategori = Kategori::count();

    // 2. Data 3 UMKM unggulan/terbaru untuk ditampilkan di card
    $umkmTerbaru = Umkm::with(['kategori', 'kelurahan'])
      ->where('status_verif', 'disetujui')
      ->oldest()
      ->take(3)
      ->get();

    // 3. Data jumlah UMKM per Kelurahan (Hanya yang disetujui)
    $kelurahans = Kelurahan::withCount(['umkm' => function ($query) {
      $query->where('status_verif', 'disetujui');
    }])->get();

    // Tambahkan kode ini di bawah query data Anda yang lain
    $umkmMaps = Umkm::with(['kategori', 'kelurahan'])
      ->where('status_verif', 'disetujui')
      ->whereNotNull('latitude') // Pastikan UMKM punya garis lintang
      ->whereNotNull('longitude') // Pastikan UMKM punya garis bujur
      ->get();

    return view('publik.beranda', compact(
      'totalUmkm',
      'totalKelurahan',
      'totalKategori',
      'umkmTerbaru',
      'kelurahans',
      'umkmMaps'
    ));
  }

  // Menampilkan halaman daftar umkm
  public function daftar()
  {
    // Mengambil data UMKM yang disetujui
    // Gunakan paginate() agar halaman tidak berat jika data mencapai ratusan
    $umkms = Umkm::with(['kategori', 'kelurahan'])
      ->where('status_verif', 'disetujui')
      ->oldest()
      ->paginate(12);

    return view('publik.daftar', compact('umkms'));
  }

  // Menampilkan halaman peta sebaran
  public function peta()
  {
    // Mengambil semua data UMKM yang disetujui dan memiliki koordinat
    $umkmMaps = Umkm::with(['kategori', 'kelurahan'])
      ->where('status_verif', 'disetujui')
      ->whereNotNull('latitude')
      ->whereNotNull('longitude')
      ->get();

    // Mengirim data ke file view public/peta.blade.php
    return view('publik.peta', compact('umkmMaps'));
  }
}
