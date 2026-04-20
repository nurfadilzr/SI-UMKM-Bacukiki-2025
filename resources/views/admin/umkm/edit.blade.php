@extends('layouts.app')

@section('content')
<style>
  /* Styling Card Utama (Skala 90%) */
  .edit-card {
    background: #FFFFFF;
    border: 1px solid var(--color-border);
    border-radius: 12px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.02);
    padding: 24px;
    width: 100%;
    position: relative;
  }

  /* Tombol Close di Kanan Atas */
  .btn-close-custom {
    position: absolute;
    top: 24px;
    right: 24px;
    background: none;
    border: none;
    font-size: 20px;
    color: var(--color-gray);
    cursor: pointer;
    transition: color 0.2s;
  }

  .btn-close-custom:hover {
    color: var(--color-black);
  }

  /* === PROGRESS STEPPER STYLING === */
  .stepper-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    position: relative;
    max-width: 700px;
    margin: 0 auto 30px auto;
  }

  .step-item {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
    gap: 8px;
  }

  .step-item:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 16px;
    left: 50%;
    width: 100%;
    height: 2px;
    background-color: var(--color-border);
    z-index: 1;
    transition: background-color 0.3s;
  }

  .step-item.step-completed:not(:last-child)::after {
    background-color: var(--color-green);
  }

  .step-circle {
    position: relative;
    z-index: 2;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: 600;
    font-size: 13px;
    border: 2px solid var(--color-border);
    color: #9CA3AF;
    background-color: #FFFFFF;
    transition: all 0.3s;
  }

  .step-active .step-circle,
  .step-completed .step-circle {
    background-color: var(--color-green);
    border-color: var(--color-green);
    color: #FFFFFF;
  }

  .step-text {
    font-size: 12px;
    font-weight: 500;
    color: #9CA3AF;
    text-align: center;
    transition: color 0.3s;
  }

  .step-active .step-text,
  .step-completed .step-text {
    color: var(--color-green);
  }

  /* === FORM & GAMBAR STYLING === */
  .info-text {
    font-size: 13px;
    color: var(--color-black);
    line-height: 1.5;
  }

  /* Styling Kotak Foto Interaktif (SOLUSI BINGUNG) */
  .foto-edit-container {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 280px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    /* Pointer menunjukkan area ini bisa diklik */
    transition: all 0.2s;
  }

  .foto-edit-container:hover {
    opacity: 0.9;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .foto-edit-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* Overlay "Tekan untuk mengganti foto" sesuai desain Figma */
  .foto-overlay-edit {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    /* Lebih gelap agar teks terbaca */
    color: white;
    padding: 10px 8px;
    text-align: center;
    font-size: 13px;
    font-weight: 500;
    transition: background 0.2s;
  }

  .foto-edit-container:hover .foto-overlay-edit {
    background: rgba(0, 0, 0, 0.85);
    /* Semakin gelap saat hover */
  }

  .form-label-custom {
    font-size: 12px;
    font-weight: 500;
    color: var(--color-black);
    margin-bottom: 6px;
  }

  /* Input Biasa (Bisa diketik) */
  .form-control-custom {
    border-radius: 6px;
    border: 1px solid #9CA3AF;
    font-size: 13px;
    color: var(--color-black);
    padding: 10px 14px;
    width: 100%;
    transition: border-color 0.2s;
  }

  .form-control-custom:focus {
    border-color: var(--color-green);
    box-shadow: 0 0 0 0.15rem var(--color-green-light);
    outline: none;
  }

  .form-control-custom::placeholder {
    color: #9CA3AF;
  }

  /* Select Dropdown styling */
  .form-select-custom {
    border-radius: 6px;
    border: 1px solid #9CA3AF;
    font-size: 13px;
    color: var(--color-black);
    padding: 10px 14px;
    width: 100%;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%239CA3AF' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 16px 12px;
    transition: border-color 0.2s;
  }

  .form-select-custom:focus {
    border-color: var(--color-green);
    box-shadow: 0 0 0 0.15rem var(--color-green-light);
    outline: none;
  }

  /* === BUTTON STYLING === */
  .btn-batal {
    background-color: white;
    color: var(--color-gray);
    border: 1px solid var(--color-border);
    border-radius: 6px;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s;
    text-decoration: none;
  }

  .btn-batal:hover {
    background-color: #F3F4F6;
  }

  .btn-selanjutnya {
    background-color: var(--color-green);
    color: white;
    border: none;
    border-radius: 6px;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s;
  }

  .btn-selanjutnya:hover {
    opacity: 0.9;
  }
</style>

<form action="{{ route('umkm.update', $umkm->id) }}" method="POST" id="form-edit" enctype="multipart/form-data">
  @csrf
  @method('PUT') <div class="edit-card">
    <h3 id="step-title" style="font-size: 20px; font-weight: 700; color: var(--color-black); margin-bottom: 30px;">Edit Data UMKM</h3>
    <!-- <a href="{{ route('umkm.index') }}" class="btn-close-custom"><iconify-icon icon="lucide:x"></iconify-icon></a> -->

    <!-- <div class="stepper-container" id="stepper">
      <div class="step-item step-active" id="stepper-1">
        <div class="step-circle">1</div>
        <span class="step-text">Edit Data</span>
      </div>
      <div class="step-item" id="stepper-2">
        <div class="step-circle">2</div>
        <span class="step-text">Input Koordinat</span>
      </div>
      <div class="step-item" id="stepper-3">
        <div class="step-circle">3</div>
        <span class="step-text">Status Verifikasi</span>
      </div>
      <div class="step-item" id="stepper-4">
        <div class="step-circle">4</div>
        <span class="step-text">Status UMKM</span>
      </div>
    </div> -->

    <div id="content-step-1">
      <!-- <p class="info-text mb-4">Silakan cek kesesuaian data UMKM di bawah. Apabila ada data yang tidak sesuai, harap lakukan perbaikan data.</p> -->

      @if ($errors->any())
      <div class="alert alert-danger" style="border-radius: 8px; font-size: 13px; border:none; background-color:rgba(211,47,47,0.1); color:#D32F2F">
        <strong>Gagal Menyimpan Data!</strong> Periksa kembali pengisian Anda.
        <ul class="mb-0 mt-1">
          @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
      </div>
      @endif

      <div class="row g-4 mb-4">

        <div class="col-lg-4">
          <div class="foto-edit-container" id="foto-preview-box">
            <div class="foto-overlay-edit">Tekan untuk mengganti foto</div>

            <img src="{{ $umkm->foto }}" id="foto-preview-img" alt="Foto UMKM {{ $umkm->nama }}" onerror="this.src='https://via.placeholder.com/800x600?text=Foto+Tidak+Ditemukan'">
          </div>

          <input type="file" name="new_foto" id="input-new-foto" style="display: none;" accept="image/jpeg,image/png,image/jpg">
        </div>

        <div class="col-lg-8">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label-custom">Nama UMKM</label>
              <input type="text" name="nama" class="form-control-custom" placeholder="Masukkan nama UMKM" value="{{ old('nama', $umkm->nama) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label-custom">Kontak UMKM</label>
              <input type="text" name="kontak" class="form-control-custom" placeholder="Masukkan kontak UMKM" value="{{ old('kontak', $umkm->kontak) }}" required>
            </div>

            <div class="col-md-6">
              <label class="form-label-custom">Kategori UMKM</label>
              <select name="kategori_id" class="form-select-custom" required>
                <option value="" disabled selected>Pilih Kategori UMKM</option>
                @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ old('kategori_id', $umkm->kategori_id) == $kategori->id ? 'selected' : '' }}>
                  {{ $kategori->kategori_umkm }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label-custom">Kelurahan UMKM</label>
              <select name="kelurahan_id" class="form-select-custom" required>
                <option value="" disabled selected>Pilih Kelurahan UMKM</option>
                @foreach($kelurahans as $kelurahan)
                <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id', $umkm->kelurahan_id) == $kelurahan->id ? 'selected' : '' }}>
                  {{ $kelurahan->nama_kelurahan }}
                </option>
                @endforeach
              </select>
            </div>

            <div class="col-12">
              <label class="form-label-custom">Alamat UMKM</label>
              <input type="text" name="alamat" class="form-control-custom" placeholder="Masukkan alamat UMKM" value="{{ old('alamat', $umkm->alamat) }}" required>
            </div>
            <div class="col-12">
              <label class="form-label-custom">Titik Lokasi UMKM</label>
              <input type="url" name="titik_maps" class="form-control-custom" placeholder="Masukkan link titik lokasi UMKM" value="{{ old('titik_maps', $umkm->titik_maps) }}" required>
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('umkm.index') }}" class="btn btn-batal">Batal</a>
        <button type="submit" class="btn btn-selanjutnya">Simpan</button>
      </div>
    </div>

  </div>
</form>

<script>
  // 💡 TRICK 1: MEMBUAT KOTAK FOTO BISA DIKLIK (SOLUSI BINGUNG)
  const fotoPreviewBox = document.getElementById('foto-preview-box');
  const inputNewFoto = document.getElementById('input-new-foto');
  const fotoPreviewImg = document.getElementById('foto-preview-img');

  // Saat pengguna mengklik area kotak foto...
  fotoPreviewBox.addEventListener('click', function() {
    // ...secara otomatis "pencet" input file tersembunyi di balik foto
    inputNewFoto.click();
  });

  // 💡 TRICK 2: PRATINJAU FOTO BARU SECARA REAL-TIME (TUTORIAL)
  // Saat pengguna SELESAI memilih file baru dari komputer...
  inputNewFoto.addEventListener('change', function() {
    // ...cek apakah file-nya ada dan file-nya adalah gambar
    const file = this.files[0];
    if (file && file.type.match('image.*')) {
      const reader = new FileReader();

      // Saat browser selesai membaca file foto tersebut...
      reader.onload = function(e) {
        // ...ganti 'src' pada tag <img> di layar dengan data foto baru
        fotoPreviewImg.src = e.target.result;
      }

      // Memulai proses membaca file
      reader.readAsDataURL(file);
    }
  });
</script>
@endsection