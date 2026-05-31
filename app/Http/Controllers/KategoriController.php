<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
	// Menampilkan halaman utama kategori beserta tabel data (Read & Search)
	public function index(Request $request)
	{
		// 1. Ambil kata kunci dari input "Cari Kategori UMKM" (jika ada)
		$keyword = $request->get('search');

		// 2. Query dasar: Ambil kategori sekalian hitung otomatis jumlah UMKM-nya
		// 'umkm' di dalam withCount() berasal dari nama fungsi relasi di Model Kategori Anda
		$query = Kategori::withCount('umkm');

		// 3. Jika admin sedang mencari sesuatu, saring berdasarkan nama kategori
		if (!empty($keyword)) {
			$query->where('kategori_umkm', 'LIKE', "%{$keyword}%");
			// Catatan: sesuaikan 'kategori_umkm' dengan nama kolom asli di tabel database Anda (misal: 'nama')
		}

		// 4. Urutkan berdasarkan data terbaru dimasukkan
		$kategoris = $query->latest()->get();

		// 5. Lempar data ke halaman blade
		return view('admin.umkm.kategori', compact('kategoris'));
	}

	// Menyimpan kategori baru ke database (Create)
	public function store(Request $request)
	{
		// 1. Validasi input wajib diisi dan tidak boleh kembar (unique)
		$request->validate([
			'kategori_umkm' => 'required|string|max:255|unique:kategori,kategori_umkm',
		], [
			'kategori_umkm.required' => 'Nama kategori tidak boleh kosong!',
			'kategori_umkm.unique'   => 'Kategori ini sudah ada di daftar.',
		]);

		// 2. Simpan ke database
		Kategori::create([
			'kategori_umkm' => $request->kategori_umkm,
			'id_admin' => Auth::id() ?? 1
		]);

		// 3. Kembali ke halaman dengan pesan sukses
		return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan!');
	}

	/**
	 * Memperbarui nama kategori (Update)
	 */
	public function update(Request $request, $id)
	{
		// 1. Validasi input edit (abaikan pengecekan unik untuk ID kategori ini sendiri)
		$request->validate([
			'kategori_umkm' => 'required|string|max:255|unique:kategori,kategori_umkm,' . $id,
		]);

		// 2. Cari data kategori dan perbarui namanya
		$kategori = Kategori::findOrFail($id);
		$kategori->update([
			'kategori_umkm' => $request->kategori_umkm
		]);

		return redirect()->back()->with('success', 'Nama kategori berhasil diubah!');
	}

	/**
	 * Menghapus kategori (Delete)
	 */
	public function destroy($id)
	{
		$kategori = Kategori::findOrFail($id);

		// Opsional: Proteksi keamanan agar kategori yang masih ada UMKM-nya tidak bisa dihapus sembarangan
		if ($kategori->umkm()->count() > 0) {
			return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh beberapa UMKM.');
		}

		$kategori->delete();

		return redirect()->back()->with('success', 'Kategori berhasil dihapus dari sistem.');
	}
}
