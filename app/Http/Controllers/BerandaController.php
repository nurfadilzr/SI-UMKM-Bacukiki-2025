<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Kelurahan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
  public function index()
  {
    // 1. Data untuk Insight Cards (Hanya UMKM yang disetujui)
    $totalUmkm = Umkm::where('status_verif', 'disetujui')->count();
    $totalKelurahan = Kelurahan::count();
    $totalKategori = Kategori::count();

    // 2. Data 3 UMKM unggulan/terbaru untuk ditampilkan di card
    $umkmTerbaru = Umkm::with(['kategori', 'kelurahan'])
      ->where('status_verif', 'disetujui')
      ->latest()
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
}
