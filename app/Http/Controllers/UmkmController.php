<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\Kelurahan;
use App\Models\Kategori;
use Intervention\Image\Laravel\Facades\Image;

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
      // 0: Timestamp/Row ID, 1: Nama UMKM, 2: Alamat, 3: Kelurahan, 4: Titik Maps, 5: Kategori, 6: WA, 7: Foto

      // Cari ID Kelurahan berdasarkan nama yang diketik di form
      $kelurahan = Kelurahan::where('nama_kelurahan', $data[3])->first();
      $id_kelurahan = $kelurahan ? $kelurahan->id : null;

      // Cari ID Kategori berdasarkan nama yang diketik di form
      $kategori = Kategori::where('kategori_umkm', $data[5])->first();
      $id_kategori = $kategori ? $kategori->id : null;

      // bersihkan nomor wa
      $kontak_raw = $data[6];
      $kontak_bersih = preg_replace('/[^0-9]/', '', $kontak_raw);
      if (str_starts_with($kontak_bersih, '0')) {
        $kontak_bersih = '62' . substr($kontak_bersih, 1);
      }

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
          'kontak' => $kontak_bersih,
          'id_kelurahan' => $id_kelurahan,
          'id_kategori' => $id_kategori,
          'foto' => $link_foto_direct,
          // Mengambil ID admin yang sedang login. 
          // Jika karena alasan tertentu auth kosong (misal saat testing), beri nilai default 1.
          'id_admin' => Auth::id() ?? 1,
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

  // 4. menampilkan tabel data umkm
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

  // 8. Menampilkan Halaman Input Manual (Tahap 1)
  public function create()
  {
    // Ambil data Kelurahan dan Kategori untuk dropdown
    $kelurahans = Kelurahan::orderBy('nama_kelurahan', 'asc')->get();
    $kategoris = Kategori::orderBy('kategori_umkm', 'asc')->get();

    // Tampilkan halaman create dan kirim datanya
    return view('admin.umkm.create', compact('kelurahans', 'kategoris'));
  }

  // 9. Menyimpan Data UMKM Baru (Hasil Input Manual Tahap 1)
  public function store(Request $request)
  {
    // Validasi input (Sertakan validasi wajib untuk 'new_foto')
    $request->validate([
      'nama' => 'required|string|max:255',
      'kontak' => 'required|string|max:20',
      'id_kategori' => 'required|exists:kategori,id',
      'id_kelurahan' => 'required|exists:kelurahan,id',
      'alamat' => 'required|string',
      'titik_maps' => 'required|url',
      'new_foto' => 'required|image|mimes:jpeg,png,jpg|max:10240' // maks 2MB
    ]);

    // Bersihkan nomor wa
    $kontak_bersih = preg_replace('/[^0-9]/', '', $request->kontak);
    if (str_starts_with($kontak_bersih, '0')) {
      $kontak_bersih = '62' . substr($kontak_bersih, 1);
    }

    // LOGIKA PENANGANAN FOTO BARU
    // if ($request->hasFile('new_foto')) {
    //   // 1. Upload foto baru ke public/uploads/umkm/
    //   $file = $request->file('new_foto');
    //   // Membuat nama file unik: ID_UMKM_BARU-Nama-Acak.ekstensi
    //   // Karena ID UMKM baru belum ada, kita gunakan string acak saja
    //   $filename = 'new-' . Str::slug($request->nama) . '-' . Str::random(5) . '.' . $file->getClientOriginalExtension();
    //   $file->move(public_path('uploads/umkm/'), $filename);

    //   // 2. Tentukan path foto baru di database
    //   $foto_path = asset('uploads/umkm/' . $filename);
    // } else {
    //   // Ini seharusnya tidak terjadi karena validasi 'required' di atas
    //   $foto_path = 'https://via.placeholder.com/800x600?text=Foto+Tidak+Ditemukan';
    // }

    if ($request->hasFile('new_foto')) {
      // 1. Ambil file dari request
      $file = $request->file('new_foto');

      // Membuat nama file unik (tetap sama seperti kodemu)
      $filename = 'new-' . Str::slug($request->nama) . '-' . Str::random(5) . '.' . $file->getClientOriginalExtension();

      // 🔴 Tentukan lokasi penyimpanan fisik absolut di server untuk Intervention
      $destinationPath = public_path('uploads/umkm/' . $filename);

      // 2. Baca gambar menggunakan Intervention Image
      $gambar = Image::read($file->getRealPath());

      // 3. Logika Kompresi Otomatis (Jika ukuran file asli di atas 2 MB / 2097152 bytes)
      if ($file->getSize() > 2097152) {
        // Pangkas resolusi secara proporsional jika terlalu lebar (misal maks lebar 1000px)
        // Pada Versi 3, kita bisa pakai fungsi scale() agar otomatis menjaga aspect ratio
        $gambar->scale(width: 1000);

        // Simpan ke folder public dengan menurunkan kualitas ke 75% (mengompres size)
        $gambar->save($destinationPath, 75);
      } else {
        // Jika ukuran aslinya sudah di bawah 2 MB, simpan dengan kualitas tinggi (95%)
        $gambar->save($destinationPath, 95);
      }

      // 4. Tentukan path foto untuk disimpan ke database (tetap pakai asset() seperti kodemu)
      $foto_path = asset('uploads/umkm/' . $filename);
    } else {
      // Ini seharusnya tidak terjadi karena validasi 'required' di atas
      $foto_path = 'https://via.placeholder.com/800x600?text=Foto+Tidak+Ditemukan';
    }

    // Perbarui data ke database
    $umkm = Umkm::create([
      'nama' => $request->nama,
      'alamat' => $request->alamat,
      'titik_maps' => $request->titik_maps,
      'kontak' => $kontak_bersih,
      'id_kelurahan' => $request->id_kelurahan,
      'id_kategori' => $request->id_kategori,
      'foto' => $foto_path, // Path foto yang sudah diproses di atas
      // Untuk data baru, status verif dan status umkm 
      // akan mengikuti default 'menunggu' dan 'aktif' dari database
    ]);

    // Kembali ke halaman tabel dengan pesan sukses
    return redirect()->route('umkm.index')->with('success', 'Data UMKM "' . $umkm->nama . '" berhasil ditambahkan secara manual!');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  // menampilkan halaman edit dengan data yg sesuai
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

  // 9. Memperbarui Data UMKM (Hasil Editan Keseluruhan)
  public function update(Request $request, $id)
  {
    $umkm = Umkm::findOrFail($id);

    // Tambahkan validasi untuk koordinat dan status
    $request->validate([
      'nama' => 'required|string|max:255',
      'kontak' => 'required|string|max:20',
      'id_kategori' => 'required|exists:kategori,id',
      'id_kelurahan' => 'required|exists:kelurahan,id',
      'alamat' => 'required|string',
      'titik_maps' => 'required|url',
      'new_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
      'latitude' => 'nullable|numeric',
      'longitude' => 'nullable|numeric',
      // 'status_verif' => 'required|in:disetujui,menunggu,ditolak',
      'status_umkm' => 'required|in:aktif,tidak'
    ]);

    // Bersihkan nomor wa
    $kontak_bersih = preg_replace('/[^0-9]/', '', $request->kontak);
    if (str_starts_with($kontak_bersih, '0')) {
      $kontak_bersih = '62' . substr($kontak_bersih, 1);
    }

    // LOGIKA PENANGANAN FOTO BARU
    // if ($request->hasFile('new_foto')) {
    //   // 1. Upload foto baru ke public/uploads/umkm/
    //   $file = $request->file('new_foto');
    //   // Membuat nama file unik: ID_UMKM_BARU-Nama-Acak.ekstensi
    //   // Karena ID UMKM baru belum ada, kita gunakan string acak saja
    //   $filename = 'new-' . Str::slug($request->nama) . '-' . Str::random(5) . '.' . $file->getClientOriginalExtension();
    //   $file->move(public_path('uploads/umkm/'), $filename);

    //   // 2. Tentukan path foto baru di database
    //   $foto_path = asset('uploads/umkm/' . $filename);
    // } else {
    //   // Ini seharusnya tidak terjadi karena validasi 'required' di atas
    //   $foto_path = 'https://via.placeholder.com/800x600?text=Foto+Tidak+Ditemukan';
    // }

    if ($request->hasFile('new_foto')) {
      // 1. Ambil file dari request
      $file = $request->file('new_foto');

      // Membuat nama file unik (tetap sama seperti kodemu)
      $filename = 'new-' . Str::slug($request->nama) . '-' . Str::random(5) . '.' . $file->getClientOriginalExtension();

      // 🔴 Tentukan lokasi penyimpanan fisik absolut di server untuk Intervention
      $destinationPath = public_path('uploads/umkm/' . $filename);

      // 2. Baca gambar menggunakan Intervention Image
      $gambar = Image::read($file->getRealPath());

      // 3. Logika Kompresi Otomatis (Jika ukuran file asli di atas 2 MB / 2097152 bytes)
      if ($file->getSize() > 2097152) {
        // Pangkas resolusi secara proporsional jika terlalu lebar (misal maks lebar 1000px)
        // Pada Versi 3, kita bisa pakai fungsi scale() agar otomatis menjaga aspect ratio
        $gambar->scale(width: 1000);

        // Simpan ke folder public dengan menurunkan kualitas ke 75% (mengompres size)
        $gambar->save($destinationPath, 75);
      } else {
        // Jika ukuran aslinya sudah di bawah 2 MB, simpan dengan kualitas tinggi (95%)
        $gambar->save($destinationPath, 95);
      }

      // 4. Tentukan path foto untuk disimpan ke database (tetap pakai asset() seperti kodemu)
      $foto_path = asset('uploads/umkm/' . $filename);
    } else {
      // Ini seharusnya tidak terjadi karena validasi 'required' di atas
      $foto_path = 'https://via.placeholder.com/800x600?text=Foto+Tidak+Ditemukan';
    }

    // LOGIKA PENANGANAN FOTO BARU
    // if ($request->hasFile('new_foto')) {
    //   $file = $request->file('new_foto');
    //   $filename = $umkm->id . '-' . Str::slug($request->nama) . '-' . Str::random(5) . '.' . $file->getClientOriginalExtension();
    //   $file->move(public_path('uploads/umkm/'), $filename);

    //   if (!str_contains($umkm->foto, 'drive.google.com') && $umkm->foto != 'https://via.placeholder.com/800x600?text=Foto+Tidak+Ditemukan') {
    //     $old_filename = basename($umkm->foto);
    //     if (file_exists(public_path('uploads/umkm/' . $old_filename))) {
    //       unlink(public_path('uploads/umkm/' . $old_filename));
    //     }
    //   }
    //   $foto_path = asset('uploads/umkm/' . $filename);
    // } else {
    //   $foto_path = $umkm->foto;
    // }

    // Perbarui SEMUA data ke database
    $umkm->update([
      'nama' => $request->nama,
      'alamat' => $request->alamat,
      'titik_maps' => $request->titik_maps,
      'kontak' => $kontak_bersih,
      'id_kelurahan' => $request->id_kelurahan,
      'id_kategori' => $request->id_kategori,
      'id_admin' => Auth::id() ?? 1,
      'latitude' => $request->latitude,
      'longitude' => $request->longitude,
      // 'status_verif' => $request->status_verif,
      'status_umkm' => $request->status_umkm,
      'foto' => $foto_path,
    ]);

    return redirect()->route('umkm.index')->with('success', 'Data UMKM "' . $umkm->nama . '" berhasil diperbarui!');
  }


  // menghapus data umkm
  public function destroy(string $id)
  {
    $umkm = Umkm::findOrFail($id);
    $umkm->delete();

    return redirect()->back()->with('success', 'Data UMKM berhasil dihapus dari sistem.');
  }

  public function verifikasi($id)
  {
    $umkm = Umkm::with(['kelurahan', 'kategori'])->findOrFail($id);

    // Ambil data kelurahan dan kategori untuk form dropdown (sama seperti Edit)
    $kelurahans = Kelurahan::orderBy('nama_kelurahan', 'asc')->get();
    $kategoris = Kategori::orderBy('kategori_umkm', 'asc')->get();

    return view('admin.umkm.verifikasi', compact('umkm', 'kelurahans', 'kategoris'));
  }

  // 7. Menyimpan Proses Verifikasi (Tahap Akhir)
  public function updateVerifikasi(Request $request, $id)
  {
    $umkm = Umkm::findOrFail($id);

    // Validasi yang sama persis dengan fungsi Edit
    $request->validate([
      'nama' => 'required|string|max:255',
      'kontak' => 'required|string|max:20',
      'id_kategori' => 'required|exists:kategori,id',
      'id_kelurahan' => 'required|exists:kelurahan,id',
      'alamat' => 'required|string',
      'titik_maps' => 'required|url',
      'new_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'latitude' => 'nullable|numeric',
      'longitude' => 'nullable|numeric',
      'status_verif' => 'required|in:disetujui,menunggu,ditolak',
      'status_umkm' => 'required|in:aktif,tidak',
      'catatan_penolakan' => 'required_if:status_verif,ditolak|nullable|string'
    ]);

    // Ambil status bawaan dari form
    $final_status_umkm = $request->status_umkm;

    // Jika ditolak, "Begal" statusnya dan paksa jadi 'tidak'
    if ($request->status_verif === 'ditolak') {
      $final_status_umkm = 'tidak';
    }

    // LOGIKA PENANGANAN FOTO BARU
    if ($request->hasFile('new_foto')) {
      $file = $request->file('new_foto');
      $filename = $umkm->id . '-' . Str::slug($request->nama) . '-' . Str::random(5) . '.' . $file->getClientOriginalExtension();
      $file->move(public_path('uploads/umkm/'), $filename);

      if (!str_contains($umkm->foto, 'drive.google.com') && $umkm->foto != 'https://via.placeholder.com/800x600?text=Foto+Tidak+Ditemukan') {
        $old_filename = basename($umkm->foto);
        if (file_exists(public_path('uploads/umkm/' . $old_filename))) {
          unlink(public_path('uploads/umkm/' . $old_filename));
        }
      }
      $foto_path = asset('uploads/umkm/' . $filename);
    } else {
      $foto_path = $umkm->foto;
    }

    // Perbarui semua data, tidak hanya status koordinat
    $umkm->update([
      'nama' => $request->nama,
      'alamat' => $request->alamat,
      'titik_maps' => $request->titik_maps,
      'kontak' => $request->kontak,
      'id_kelurahan' => $request->id_kelurahan,
      'id_kategori' => $request->id_kategori,
      'latitude' => $request->latitude,
      'longitude' => $request->longitude,
      'status_verif' => $request->status_verif,
      'status_umkm' => $final_status_umkm,
      'foto' => $foto_path,
    ]);

    // Cek apakah data ini baru saja ditolak
    if ($request->status_verif === 'ditolak') {
      // Redirect dengan membawa data khusus (wa_rejected)
      return redirect()->route('umkm.index')
        ->with('success', 'Verifikasi selesai! Data UMKM berhasil ditolak.')
        ->with('wa_rejected', [
          'nama' => $umkm->nama,
          'kontak' => $umkm->kontak,
          'alasan' => $request->catatan_penolakan
        ]);
    }

    // Jika disetujui / menunggu, redirect biasa
    return redirect()->route('umkm.index')
      ->with('success', 'Data UMKM "' . $umkm->nama . '"  telah diverifikasi.');
  }
}
