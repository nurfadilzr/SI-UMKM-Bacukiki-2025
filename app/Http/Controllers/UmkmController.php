<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\Kelurahan;
use App\Models\Kategori;

class UmkmController extends Controller
{
  // 1. Menampilkan halaman form upload
  public function showImportForm()
  {
    return view('admin.umkm.import');
  }

  // 2. Fungsi mengubah Link Google Drive menjadi Direct Image Link
  private function convertDriveLink($url)
  {
    // Mencari string acak (ID Drive) yang panjangnya minimal 25 karakter
    // Terdiri dari huruf, angka, strip (-), dan underscore (_)
    if (preg_match('/[-\w]{25,}/', $url, $matches)) {
      $fileId = $matches[0];

      // Menggunakan endpoint Thumbnail (Lebih stabil & anti-error untuk tag <img>)
      return "https://drive.google.com/thumbnail?id=" . $fileId . "&sz=w800";
    }
    return $url;
  }

  // 3. Proses membaca file CSV
  public function processImport(Request $request)
  {
    // Validasi file harus berupa CSV
    $request->validate([
      'file_csv' => 'required|mimes:csv,txt|max:2048',
    ]);

    $file = $request->file('file_csv');
    $handle = fopen($file->path(), 'r');

    // Lewati baris pertama jika itu adalah header (judul kolom Excel)
    fgetcsv($handle);

    $row_number = 2; // Mulai dari baris ke-2 (karena baris 1 header)

    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
      // Asumsi urutan kolom CSV (Sesuaikan dengan file Excel/Spreadsheet-mu):
      // 0: Timestamp/Row ID, 1: Nama UMKM, 2: Alamat, 3: Kontak, 4: Titik Maps, 5: Nama Kelurahan, 6: Nama Kategori, 7: Link Foto
      // 0: Timestamp/Row ID, 1: Nama UMKM, 2: Alamat, 3: Kelurahan, 4: Titik Maps, 5: Kategori, 6: WA, 7: Foto

      // Cari ID Kelurahan berdasarkan nama yang diketik di form
      $kelurahan = Kelurahan::where('nama_kelurahan', $data[3])->first();
      $kelurahan_id = $kelurahan ? $kelurahan->id : null;

      // Cari ID Kategori berdasarkan nama yang diketik di form
      $kategori = Kategori::where('kategori_umkm', $data[5])->first();
      $kategori_id = $kategori ? $kategori->id : null;

      // Proses link foto
      $link_foto_asli = $data[7];
      $link_foto_direct = $this->convertDriveLink($link_foto_asli);

      // updateOrCreate: Cari data. Jika ada, Timpali/Update. Jika tidak ada, buat baru.
      // firstOrCreate: Cari data. Jika ada, Abaikan/Biarkan saja. Jika tidak ada, buat baru.
      Umkm::firstOrCreate(
        [
          // Patokan data unik (Misal dari Timestamp form atau ID khusus di Spreadsheet)
          'spreadsheet_row_id' => $data[0]
        ],
        [
          'nama' => $data[1],
          'alamat' => $data[2],
          'titik_maps' => $data[4],
          'kontak' => $data[6],
          'kelurahan_id' => $kelurahan_id,
          'kategori_id' => $kategori_id,
          'foto' => $link_foto_direct,
          // Status default 'menunggu' dan 'aktif' otomatis terisi oleh database, 
          // tapi jika ingin dipertegas, bisa ditulis di sini:
          // 'status_verif' => 'menunggu',
          // 'status_umkm' => 'aktif',
        ]
      );
      $row_number++;
    }

    fclose($handle);

    return redirect()->back()->with('success', 'Data UMKM berhasil di-import dan sedang menunggu verifikasi!');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    // Mulai query dengan mengambil relasinya juga agar query database lebih efisien
    $query = Umkm::with(['kelurahan', 'kategori']);

    // Jika Admin mengisi kolom pencarian (Nama UMKM)
    if ($request->filled('search')) {
      $query->where('nama', 'like', '%' . $request->search . '%');
    }

    // Jika Admin memilih filter Status Verifikasi
    if ($request->filled('status_verif')) {
      $query->where('status_verif', $request->status_verif);
    }

    // Jika Admin memilih filter Status Aktif
    if ($request->filled('status_umkm')) {
      $query->where('status_umkm', $request->status_umkm);
    }

    // Ambil datanya, urutkan dari yang terbaru, dan batasi 10 data per halaman (Pagination)
    $umkms = $query->latest()->paginate(10);

    return view('admin.umkm.index', compact('umkms'));

    // $data = Umkm::with(['kelurahan', 'kategori'])->get();
    // return view('umkm.index', compact('data'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    // Ambil data UMKM berdasarkan ID, sertakan juga relasi kelurahan & kategori
    $umkm = Umkm::with(['kelurahan', 'kategori'])->findOrFail($id);

    // Ambil data Kelurahan dan Kategori untuk dropdown
    $kelurahans = Kelurahan::orderBy('nama_kelurahan', 'asc')->get();
    $kategoris = Kategori::orderBy('kategori_umkm', 'asc')->get();

    // Tampilkan halaman edit dan kirim datanya
    return view('admin.umkm.edit', compact('umkm', 'kelurahans', 'kategoris'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    // Cari data UMKM
    $umkm = Umkm::findOrFail($id);

    // Validasi input (Sertakan validasi untuk 'new_foto')
    $request->validate([
      'nama' => 'required|string|max:255',
      'kontak' => 'required|string|max:20',
      'kategori_id' => 'required|exists:kategori,id',
      'kelurahan_id' => 'required|exists:kelurahan,id',
      'alamat' => 'required|string',
      'titik_maps' => 'required|url',
      // Validasi foto baru (nullable karena boleh kosong jika tidak diganti)
      'new_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // maks 2MB
    ]);

    // LOGIKA PENANGANAN FOTO BARU
    if ($request->hasFile('new_foto')) {
      // 1. Upload foto baru ke public/uploads/fotos/
      $file = $request->file('new_foto');
      // Membuat nama file unik: ID_UMKM-Nama-Acak.ekstensi
      $filename = $umkm->id . '-' . Str::slug($request->nama) . '-' . Str::random(5) . '.' . $file->getClientOriginalExtension();
      $file->move(public_path('uploads/umkm/'), $filename);

      // 2. Hapus foto lama JIKA foto lama tersebut adalah file lokal (bukan GDrive)
      // Kita anggap foto lokal adalah file di 'uploads/fotos/'
      if (!str_contains($umkm->foto, 'drive.google.com') && $umkm->foto != 'https://via.placeholder.com/800x600?text=Foto+Tidak+Ditemukan') {
        // Trik: dapatkan nama file dari path lokal
        $old_filename = basename($umkm->foto);
        if (file_exists(public_path('uploads/umkm/' . $old_filename))) {
          unlink(public_path('uploads/umkm/' . $old_filename));
        }
      }

      // 3. Update path foto baru di database
      $foto_path = asset('uploads/umkm/' . $filename);
    } else {
      // Gunakan foto lama jika tidak ada file baru diunggah
      $foto_path = $umkm->foto;
    }

    // Perbarui data ke database
    $umkm->update([
      'nama' => $request->nama,
      'alamat' => $request->alamat,
      'titik_maps' => $request->titik_maps,
      'kontak' => $request->kontak,
      'kelurahan_id' => $request->kelurahan_id,
      'kategori_id' => $request->kategori_id,
      'foto' => $foto_path, // Path foto yang sudah diproses di atas
    ]);

    // Kembali ke halaman tabel dengan pesan sukses
    return redirect()->route('umkm.index')->with('success', 'Data UMKM "' . $umkm->nama . '" berhasil diperbarui!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $umkm = Umkm::findOrFail($id);
    $umkm->delete();

    return redirect()->back()->with('success', 'Data UMKM berhasil dihapus dari sistem.');
  }

  public function verifikasi($id)
  {
    // Ambil data UMKM berdasarkan ID, sertakan juga relasi kelurahan & kategori
    $umkm = Umkm::with(['kelurahan', 'kategori'])->findOrFail($id);

    // Tampilkan halaman verifikasi dan kirim datanya
    return view('admin.umkm.verifikasi', compact('umkm'));
  }

  // 7. Menyimpan Proses Verifikasi (Tahap Akhir)
  public function updateVerifikasi(Request $request, $id)
  {
    // Cari data UMKM
    $umkm = Umkm::findOrFail($id);

    // Validasi input (Latitude/Longitude boleh kosong, tapi Status wajib diisi)
    $request->validate([
      'latitude' => 'nullable|numeric',
      'longitude' => 'nullable|numeric',
      'status_verif' => 'required|in:disetujui,menunggu,ditolak',
      'status_umkm' => 'required|in:aktif,tidak'
    ]);

    // Perbarui data ke database
    $umkm->update([
      'latitude' => $request->latitude,
      'longitude' => $request->longitude,
      'status_verif' => $request->status_verif,
      'status_umkm' => $request->status_umkm
    ]);

    // Kembali ke halaman tabel dengan pesan sukses
    return redirect()->route('umkm.index')->with('success', 'Data UMKM "' . $umkm->nama . '" berhasil diverifikasi dan diperbarui!');
  }
}
