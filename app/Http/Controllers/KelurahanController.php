<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelurahan;
use Illuminate\Support\Facades\Auth;

class KelurahanController extends Controller
{
  // Menampilkan halaman utama kategori beserta tabel data (Read & Search)
  public function index(Request $request)
  {
    // 1. Ambil kata kunci dari input "Cari Kategori UMKM" (jika ada)
    $keyword = $request->get('search');

    // 2. Query dasar: Ambil kategori sekalian hitung otomatis jumlah UMKM-nya
    // 'umkm' di dalam withCount() berasal dari nama fungsi relasi di Model kelurahan Anda
    $query = Kelurahan::withCount('umkm');

    // 3. Jika admin sedang mencari sesuatu, saring berdasarkan nama kategori
    if (!empty($keyword)) {
      $query->where('nama_kelurahan', 'LIKE', "%{$keyword}%");
      // Catatan: sesuaikan 'kategori_umkm' dengan nama kolom asli di tabel database Anda (misal: 'nama')
    }

    // 4. Urutkan berdasarkan data terbaru dimasukkan
    $kelurahans = $query->oldest()->get();

    // 5. Lempar data ke halaman blade
    return view('admin.umkm.kelurahan', compact('kelurahans'));
  }

  // Menyimpan kategori baru ke database (Create)
  public function store(Request $request)
  {
    // 1. Validasi input wajib diisi dan tidak boleh kembar (unique)
    $request->validate([
      'nama_kelurahan' => 'required|string|max:255|unique:kelurahan,nama_kelurahan',
    ], [
      'nama_kelurahan.required' => 'Nama kelurahan tidak boleh kosong!',
      'nama_kelurahan.unique'   => 'Kelurahan ini sudah ada di daftar.',
    ]);

    // 2. Simpan ke database
    Kelurahan::create([
      'nama_kelurahan' => $request->nama_kelurahan,
      'id_admin' => Auth::id() ?? 1
    ]);

    // 3. Kembali ke halaman dengan pesan sukses
    return redirect()->back()->with('success', 'Kelurahan baru berhasil ditambahkan!');
  }

  /**
   * Memperbarui nama kategori (Update)
   */
  public function update(Request $request, $id)
  {
    // 1. Validasi input edit (abaikan pengecekan unik untuk ID kategori ini sendiri)
    $request->validate([
      'nama_kelurahan' => 'required|string|max:255|unique:kelurahan,nama_kelurahan,' . $id,
    ]);

    // 2. Cari data kategori dan perbarui namanya
    $kelurahan = Kelurahan::findOrFail($id);
    $kelurahan->update([
      'nama_kelurahan' => $request->nama_kelurahan
    ]);

    return redirect()->back()->with('success', 'Nama kelurahan berhasil diubah!');
  }

  /**
   * Menghapus kategori (Delete)
   */
  public function destroy($id)
  {
    $kelurahan = Kelurahan::findOrFail($id);

    // Opsional: Proteksi keamanan agar kategori yang masih ada UMKM-nya tidak bisa dihapus sembarangan
    if ($kelurahan->umkm()->count() > 0) {
      return redirect()->back()->with('error', 'Kelurahan tidak bisa dihapus karena masih memiliki beberapa UMKM.');
    }

    $kelurahan->delete();

    return redirect()->back()->with('success', 'Kelurahan berhasil dihapus dari sistem.');
  }
}
