<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;

class PetaController extends Controller
{
  public function petaSebaran()
  {
    // Ambil data UMKM yang disetujui dan memiliki koordinat
    // Eager load 'kategori' dan 'kelurahan' agar datanya ikut terbawa
    $umkms = Umkm::with(['kategori', 'kelurahan'])
      ->where('status_verif', 'disetujui')
      ->whereNotNull('latitude')
      ->whereNotNull('longitude')
      ->get();

    return view('admin.umkm.peta', compact('umkms'));
  }
}
