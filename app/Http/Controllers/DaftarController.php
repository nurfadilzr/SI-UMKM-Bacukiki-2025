<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Kategori;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class DaftarController extends Controller
{
  public function index(Request $request)
  {
    /// Mengambil filter dari URL (jika ada)
    $search = $request->search;
    $kategori = $request->kategori;
    $kelurahan = $request->kelurahan;

    // Query dasar (Hanya tampilkan yang disetujui / aktif saja, jika diperlukan)
    $query = Umkm::with(['kategori', 'kelurahan'])->where('status_verif', 'disetujui');

    // Terapkan filter pencarian
    if ($search) {
      $query->where('nama', 'like', "%{$search}%");
    }
    if ($kategori) {
      $query->where('id_kategori', $kategori);
    }
    if ($kelurahan) {
      $query->where('id_kelurahan', $kelurahan);
    }

    $umkms = $query->oldest()->paginate(12); // Menampilkan 12 Card terlama per halaman

    // Ambil data untuk dropdown filter
    $kategoris = Kategori::orderBy('kategori_umkm', 'asc')->get();
    $kelurahans = Kelurahan::orderBy('nama_kelurahan', 'asc')->get();

    return view('admin.umkm.daftar', compact('umkms', 'kategoris', 'kelurahans'));
  }
}
