@extends('layouts.app')

@section('content')
<style>
  .edit-card {
    background: #FFFFFF;
    border: 1px solid var(--color-border);
    border-radius: 12px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.02);
    padding: 24px;
    width: 100%;
    position: relative;
  }

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

  /* === MENU TAB STYLING === */
  .edit-tabs {
    display: flex;
    gap: 12px;
    border-bottom: 2px solid var(--color-border);
    padding-bottom: 16px;
    margin-bottom: 16px;
    overflow-x: auto;
    /* Agar tidak rusak di layar kecil */
  }

  .tab-btn {
    background: none;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 600;
    color: var(--color-gray-500);
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s;
  }

  .tab-btn:hover {
    background-color: var(--color-green-300);
    color: #FFFFFF;
  }

  /* Tab Aktif */
  .tab-btn.active {
    background-color: var(--color-green-300);
    color: var(--color-green);
  }

  /* === FORM & GAMBAR STYLING === */
  .form-section {
    display: none;
  }

  /* Semua disembunyikan dulu */
  .form-section.active {
    display: block;
  }

  /* Yang aktif dimunculkan */

  .foto-edit-container {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 280px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
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

  .foto-overlay-edit {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 10px 8px;
    text-align: center;
    font-size: 13px;
    font-weight: 500;
  }

  .form-label-custom {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: var(--color-black);
    margin-bottom: 6px;
  }

  .form-control-custom {
    border-radius: 6px;
    border: 1px solid #9CA3AF;
    font-size: 13px;
    color: var(--color-black);
    padding: 10px 14px;
    width: 100%;
  }

  .form-select-custom {
    display: block;
    width: 100%;
    /* Ini kunci agar selebar input lainnya */
    padding: 10px 14px;
    font-size: 13px;
    color: var(--color-black);
    background-color: #FFFFFF;
    border: 1px solid #9CA3AF;
    border-radius: 6px;

    /* Menghilangkan panah dropdown jadul bawaan browser */
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;

    /* Menggantinya dengan panah custom yang lebih modern */
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%239CA3AF' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 14px center;
    background-size: 14px 10px;
    transition: border-color 0.2s;
  }

  .form-control-custom:focus,
  .form-select-custom:focus {
    border-color: var(--color-green);
    box-shadow: 0 0 0 0.15rem var(--color-green-light);
    outline: none;
  }

  /* Radio Buttons */
  .form-check-input:checked {
    background-color: var(--color-green);
    border-color: var(--color-green);
  }

  .form-check-label {
    font-size: 13px;
    color: var(--color-black);
    cursor: pointer;
  }

  .form-control-readonly {
    background-color: var(--color-gray-50);
    border: 1px solid transparent;
    border-radius: 6px;
    padding: 10px 14px;
    font-size: 13px;
    color: var(--color-gray-700);
    width: 100%;
    pointer-events: none;
  }

  /* === BUTTON STYLING === */
  .btn-batal {
    background-color: white;
    color: var(--color-gray);
    border: 1.5px solid var(--color-gray-500);
    border-radius: 6px;
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.1s;
  }

  .btn-batal:hover {
    background-color: var(--color-gray-50);
    border: 1.5px solid var(--color-gray-500);
  }

  .btn-simpan {
    background-color: var(--color-green-800);
    color: white;
    border: none;
    border-radius: 6px;
    padding: 8px 14px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
  }

  .btn-simpan:hover {
    color: white;
    background-color: var(--color-green);
  }

  .btn-maps {
    background-color: var(--color-blue-200);
    color: var(--color-blue);
    border: 1.5px solid var(--color-blue);
    border-radius: 6px;
    padding: 8px 16px;
    font-size: 12px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: background 0.2s;
  }

  .btn-maps:hover {
    background-color: #CBD5E1;
    color: var(--color-blue);
  }
</style>

<form action="{{ route('umkm.update', $umkm->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="edit-card">
    <h3 style="font-size: 20px; font-weight: 700; color: var(--color-black); margin-bottom: 24px;">Edit Data UMKM</h3>

    @if ($errors->any())
    <div class="alert alert-danger" style="border-radius: 8px; font-size: 13px; border:none; background-color:rgba(211,47,47,0.1); color:#D32F2F">
      <strong>Gagal Menyimpan Data!</strong> Ada kesalahan isian di salah satu tab:
      <ul class="mb-0 mt-1">
        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
      </ul>
    </div>
    @endif

    <div class="edit-tabs">
      <button type="button" class="tab-btn active" onclick="switchTab('tab-1', this)">Informasi Dasar</button>
      <button type="button" class="tab-btn" onclick="switchTab('tab-2', this)">Titik Koordinat</button>
      <!-- <button type="button" class="tab-btn" onclick="switchTab('tab-3', this)">Status Verifikasi</button> -->
      <button type="button" class="tab-btn" onclick="switchTab('tab-4', this)">Status UMKM</button>
    </div>

    <div id="tab-1" class="form-section active">
      <div class="row g-4 mb-4">
        <div class="col-lg-4">
          <div class="foto-edit-container" id="foto-preview-box">
            <div class="foto-overlay-edit">Tekan untuk mengganti foto</div>
            <img src="{{ $umkm->foto }}" id="foto-preview-img" onerror="this.src='https://via.placeholder.com/800x600?text=Foto+Tidak+Ditemukan'">
          </div>
          <input type="file" name="new_foto" id="input-new-foto" style="display: none;" accept="image/jpeg,image/png,image/jpg">
        </div>

        <div class="col-lg-8">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label-custom">Nama UMKM</label>
              <input type="text" name="nama" class="form-control-custom" value="{{ old('nama', $umkm->nama) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label-custom">Kontak UMKM</label>
              <input type="text" name="kontak" class="form-control-custom" value="{{ old('kontak', $umkm->kontak) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label-custom">Kategori UMKM</label>
              <select name="id_kategori" class="form-select-custom" required>
                @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ old('id_kategori', $umkm->id_kategori) == $kategori->id ? 'selected' : '' }}>{{ $kategori->kategori_umkm }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label-custom">Kelurahan UMKM</label>
              <select name="id_kelurahan" class="form-select-custom" required>
                @foreach($kelurahans as $kelurahan)
                <option value="{{ $kelurahan->id }}" {{ old('id_kelurahan', $umkm->id_kelurahan) == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <label class="form-label-custom">Alamat UMKM</label>
              <input type="text" name="alamat" class="form-control-custom" value="{{ old('alamat', $umkm->alamat) }}" required>
            </div>
            <div class="col-12">
              <label class="form-label-custom">Titik Lokasi UMKM</label>
              <input type="url" name="titik_maps" class="form-control-custom" value="{{ old('titik_maps', $umkm->titik_maps) }}" required>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="tab-2" class="form-section">
      <div class="mb-3" style="max-width: 350px;">
        <label class="form-label-custom">Nama UMKM</label>
        <input type="text" class="form-control-readonly" value="{{ $umkm->nama }}" readonly>
      </div>
      <div class="mb-4">
        <label class="form-label-custom">Titik Lokasi UMKM</label>
        <a href="{{ $umkm->titik_maps }}" target="_blank" class="btn btn-maps">
          <iconify-icon icon="lucide:map-pin" style="font-size: 16px;"></iconify-icon> Buka di Google Maps
        </a>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-md-6">
          <label class="form-label-custom">Latitude (Lintang)</label>
          <input type="text" name="latitude" class="form-control-custom" value="{{ old('latitude', $umkm->latitude) }}">
        </div>
        <div class="col-md-6">
          <label class="form-label-custom">Longitude (Bujur)</label>
          <input type="text" name="longitude" class="form-control-custom" value="{{ old('longitude', $umkm->longitude) }}">
        </div>
      </div>
    </div>

    <!-- <div id="tab-3" class="form-section">
      <div class="row g-5 mb-4">
        <div class="col-md-6">
          <div class="mb-3" style="max-width: 350px;">
            <label class="form-label-custom">Nama UMKM</label>
            <input type="text" class="form-control-readonly" value="{{ $umkm->nama }}" readonly>
          </div>
          <label class="form-label-custom mb-2" style="font-size: 13px; font-weight: 500;">Ubah Status Verifikasi</label>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_verif" id="verif_disetujui" value="disetujui" {{ old('status_verif', $umkm->status_verif) == 'disetujui' ? 'checked' : '' }} required>
            <label class="form-check-label" for="verif_disetujui">Disetujui</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_verif" id="verif_menunggu" value="menunggu" {{ old('status_verif', $umkm->status_verif) == 'menunggu' ? 'checked' : '' }} required>
            <label class="form-check-label" for="verif_menunggu">Menunggu</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_verif" id="verif_ditolak" value="ditolak" {{ old('status_verif', $umkm->status_verif) == 'ditolak' ? 'checked' : '' }} required>
            <label class="form-check-label" for="verif_ditolak">Ditolak</label>
          </div>
        </div>
      </div>
    </div> -->

    <div id="tab-4" class="form-section">
      <div class="row g-5 mb-4">
        <div class="col-md-6">
          <div class="mb-3" style="max-width: 350px;">
            <label class="form-label-custom">Nama UMKM</label>
            <input type="text" class="form-control-readonly" value="{{ $umkm->nama }}" readonly>
          </div>
          <label class="form-label-custom mb-2" style="font-size: 13px; font-weight: 500;">Ubah Status UMKM</label>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_umkm" id="aktif_ya" value="aktif" {{ old('status_umkm', $umkm->status_umkm) == 'aktif' ? 'checked' : '' }} required>
            <label class="form-check-label" for="aktif_ya">Aktif</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_umkm" id="aktif_tidak" value="tidak" {{ old('status_umkm', $umkm->status_umkm) == 'tidak' ? 'checked' : '' }} required>
            <label class="form-check-label" for="aktif_tidak">Tidak Aktif</label>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end gap-3 mt-5 pt-3" style="border-top: 1px solid var(--color-border);">
      <a href="{{ route('umkm.index') }}" class="btn btn-batal">Batal</a>
      <button type="submit" class="btn btn-simpan">Simpan Perubahan</button>
    </div>

  </div>
</form>

<script>
  // FUNGSI GANTI TAB
  function switchTab(tabId, clickedBtn) {
    // 1. Sembunyikan semua konten tab
    document.querySelectorAll('.form-section').forEach(el => el.classList.remove('active'));

    // 2. Hilangkan warna aktif dari semua tombol tab
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

    // 3. Tampilkan tab yang dipilih
    document.getElementById(tabId).classList.add('active');

    // 4. Beri warna aktif pada tombol yang ditekan
    clickedBtn.classList.add('active');
  }

  // FUNGSI UPLOAD FOTO (Sama seperti sebelumnya)
  const fotoPreviewBox = document.getElementById('foto-preview-box');
  const inputNewFoto = document.getElementById('input-new-foto');
  const fotoPreviewImg = document.getElementById('foto-preview-img');

  fotoPreviewBox.addEventListener('click', function() {
    inputNewFoto.click();
  });

  inputNewFoto.addEventListener('change', function() {
    const file = this.files[0];
    if (file && file.type.match('image.*')) {
      const reader = new FileReader();
      reader.onload = function(e) {
        fotoPreviewImg.src = e.target.result;
      }
      reader.readAsDataURL(file);
    }
  });
</script>
@endsection