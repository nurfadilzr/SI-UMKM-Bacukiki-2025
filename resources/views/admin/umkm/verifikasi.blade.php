@extends('layouts.app')

@section('content')
<style>
  /* === STYLING UMUM === */
  .verif-card {
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
    top: 20px;
    left: 50%;
    width: 100%;
    height: 2px;
    background-color: #B3B3B3;
    z-index: 0;
    transition: background-color 0.3s;
  }

  .step-item.step-completed:not(:last-child)::after {
    background-color: var(--color-green);
  }

  .step-circle {
    position: relative;
    z-index: 1;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: 600;
    font-size: 13px;
    border: 2px solid #B3B3B3;
    color: #B3B3B3;
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
    color: #B3B3B3;
    text-align: center;
    transition: color 0.3s;
  }

  .step-active .step-text,
  .step-completed .step-text {
    color: var(--color-green);
  }

  /* === FORM STYLING === */
  .info-text {
    font-size: 15px;
    font-weight: 500;
    color: var(--color-black);
    margin-bottom: 24px;
    line-height: 1.5;
  }

  .foto-preview-container {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 280px;
    border-radius: 8px;
    overflow: hidden;
  }

  .foto-preview-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .foto-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.6);
    color: white;
    padding: 8px;
    text-align: center;
    font-size: 12px;
    font-weight: 500;
  }

  .form-label-custom {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: var(--color-black);
    margin-bottom: 6px;
  }

  /* Memaksa dropdown selebar 100% dan menyeragamkan bentuknya dengan input teks */
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

  /* Efek menyala hijau saat dropdown diklik */
  .form-select-custom:focus,
  .form-control-custom:focus {
    border-color: var(--color-green);
    box-shadow: 0 0 0 0.15rem var(--color-green-light);
    outline: none;
  }

  .form-control-readonly {
    background-color: var(--color-gray-50);
    border: 1px solid transparent;
    border-radius: 6px;
    padding: 10px 14px;
    font-size: 13px;
    color: var(--color-gray-600);
    width: 100%;
    pointer-events: none;
  }

  .form-control-custom {
    border-radius: 6px;
    border: 1px solid var(--color-gray-500);
    font-size: 13px;
    color: var(--color-black);
    padding: 10px 14px;
    width: 100%;
  }

  /* Kustomisasi Radio Button agar warnanya hijau saat diklik */
  .form-check-input:checked {
    background-color: var(--color-green);
    border-color: var(--color-green);
  }

  .form-check-input:focus {
    box-shadow: 0 0 0 0.25rem var(--color-green-light);
    border-color: var(--color-green);
  }

  .form-check-label {
    font-size: 13px;
    color: var(--color-black);
    cursor: pointer;
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

  .btn-selanjutnya {
    background-color: var(--color-green-800);
    color: white;
    border: none;
    border-radius: 6px;
    padding: 8px 14px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
  }

  .btn-selanjutnya:hover {
    color: white;
    background-color: var(--color-green);
  }

  .btn-panduan {
    background-color: var(--color-blue-600);
    color: white;
    border: none;
    border-radius: 6px;
    padding: 10px 14px;
    font-size: 13px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }

  .btn-panduan:hover {
    background-color: var(--color-blue-700);
    color: white;
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

<div class="container-fluid mb-5 p-3 p-md-4 ">
  <form action="{{ route('umkm.updateVerifikasi', $umkm->id) }}" method="POST" id="form-verifikasi" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="verif-card">

      @if ($errors->any())
      <div class="alert alert-danger" style="border-radius: 8px; font-size: 13px;">
        <strong>Gagal Menyimpan Data!</strong> Silakan perbaiki kesalahan berikut:
        <ul class="mb-0 mt-1">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <h3 id="step-title" style="font-size: 20px; font-weight: 700; color: var(--color-black); margin-bottom: 30px;">Verifikasi Data UMKM</h3>
      <div class="stepper-container" id="stepper">
        <div class="step-item step-active" id="stepper-1">
          <div class="step-circle">1</div>
          <span class="step-text">Verifikasi</span>
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
      </div>

      <div id="content-step-1">
        <p class="info-text mb-4">Silakan cek kesesuaian data UMKM di bawah. Anda dapat langsung mengedit data jika terdapat ketidaksesuaian.</p>

        <div class="row g-4 mb-4">
          <div class="col-lg-4">
            <div class="foto-edit-container" id="foto-preview-box" style="position:relative; width:100%; height:100%; min-height:280px; border-radius:8px; overflow:hidden; cursor:pointer;">
              <div class="foto-overlay-edit" style="position:absolute; bottom:0; left:0; right:0; background:rgba(0,0,0,0.7); color:white; padding:10px 8px; text-align:center; font-size:13px; font-weight:500;">Tekan untuk mengganti foto</div>
              <img src="{{ $umkm->foto }}" id="foto-preview-img" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='https://via.placeholder.com/800x600?text=Foto+Tidak+Ditemukan'">
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
              @php
              // LOGIKA KATEGORI: Cek apakah ada error validasi (old), jika tidak ada cek data database ($umkm)
              $currentKategoriId = old('id_kategori', $umkm->id_kategori ?? '');
              $currentKategoriName = 'Pilih Kategori UMKM';
              if ($currentKategoriId) {
              $kategoriRecord = $kategoris->firstWhere('id', $currentKategoriId);
              $currentKategoriName = $kategoriRecord ? $kategoriRecord->kategori_umkm : 'Pilih Kategori UMKM';
              }

              // LOGIKA KELURAHAN: Sama seperti kategori
              $currentKelurahanId = old('id_kelurahan', $umkm->id_kelurahan ?? '');
              $currentKelurahanName = 'Pilih Kelurahan UMKM';
              if ($currentKelurahanId) {
              $kelurahanRecord = $kelurahans->firstWhere('id', $currentKelurahanId);
              $currentKelurahanName = $kelurahanRecord ? $kelurahanRecord->nama_kelurahan : 'Pilih Kelurahan UMKM';
              }
              @endphp

              <div class="col-md-6">
                <label class="form-label-custom">Kategori UMKM</label>
                <div class="dropdown w-100">
                  <button class="btn form-control-custom w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="btn-kategori" style="background-color: #FFFFFF;">
                    <span id="label-kategori" class="text-truncate {{ $currentKategoriId ? '' : 'text-muted' }}" @if($currentKategoriId) style="color: var(--color-black);" @endif>
                      {{ $currentKategoriName }}
                    </span>
                    <iconify-icon icon="lucide:chevron-down" style="color: #9CA3AF; min-width: 16px;"></iconify-icon>
                  </button>
                  <ul class="dropdown-menu w-100 shadow-sm" style="border-radius: 8px; font-size: 13px; border: 1px solid #E5E7EB; padding: 8px 0; max-height: 250px; overflow-y: auto;">
                    @foreach($kategoris as $kategori)
                    <li><a class="dropdown-item py-2" href="#" onclick="pilihDropdown('kategori', '{{ $kategori->id }}', '{{ $kategori->kategori_umkm }}', event)">{{ $kategori->kategori_umkm }}</a></li>
                    @endforeach
                  </ul>
                  <input type="text" name="id_kategori" id="input-kategori" value="{{ $currentKategoriId }}" style="opacity: 0; position: absolute; z-index: -1; width: 1px; height: 1px;" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label-custom">Kelurahan UMKM</label>
                <div class="dropdown w-100">
                  <button class="btn form-control-custom w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="btn-kelurahan" style="background-color: #FFFFFF;">
                    <span id="label-kelurahan" class="text-truncate {{ $currentKelurahanId ? '' : 'text-muted' }}" @if($currentKelurahanId) style="color: var(--color-black);" @endif>
                      {{ $currentKelurahanName }}
                    </span>
                    <iconify-icon icon="lucide:chevron-down" style="color: #9CA3AF; min-width: 16px;"></iconify-icon>
                  </button>
                  <ul class="dropdown-menu w-100 shadow-sm" style="border-radius: 8px; font-size: 13px; border: 1px solid #E5E7EB; padding: 8px 0; max-height: 250px; overflow-y: auto;">
                    @foreach($kelurahans as $kelurahan)
                    <li><a class="dropdown-item py-2" href="#" onclick="pilihDropdown('kelurahan', '{{ $kelurahan->id }}', '{{ $kelurahan->nama_kelurahan }}', event)">{{ $kelurahan->nama_kelurahan }}</a></li>
                    @endforeach
                  </ul>
                  <input type="text" name="id_kelurahan" id="input-kelurahan" value="{{ $currentKelurahanId }}" style="opacity: 0; position: absolute; z-index: -1; width: 1px; height: 1px;" required>
                </div>
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

        <!-- <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="{{ route('umkm.index') }}" class="btn btn-batal text-decoration-none">Batal</a>
          <button type="button" class="btn btn-selanjutnya" onclick="goToStep(2)">Selanjutnya</button>
        </div> -->

        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="{{ route('umkm.index') }}" class="btn btn-batal text-decoration-none">Batal</a>
          <button type="button" class="btn btn-selanjutnya" onclick="validasiDanLanjut(1, 2)">Selanjutnya</button>
        </div>
      </div>

      <div id="content-step-2" style="display: none;">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <p class="info-text m-0" style="max-width: 75%;">Silakan input titik koordinat lokasi UMKM. Bila Anda belum mengetahui cara mendapatkan titik koordinat, klik tombol di samping.</p>
          <a href="https://docs.google.com/document/d/1JmJYP7vHWA6wmZHJ9xqZ2lJ_ZzdvJuNGbdQ9m4TZb0o/edit?usp=sharing" target="_blank" class="btn btn-panduan">
            <iconify-icon icon="lucide:help-circle" style="font-size: 16px;"></iconify-icon> Panduan
          </a>
        </div>
        <div class="mb-4">
          <label class="form-label-custom">Titik Lokasi UMKM</label>
          <a href="{{ $umkm->titik_maps }}" target="_blank" class="btn btn-maps">
            <iconify-icon icon="lucide:map-pin" style="font-size: 16px;"></iconify-icon> Buka di Google Maps
          </a>
        </div>
        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <label class="form-label-custom">Latitude</label>
            <input type="text" name="latitude" class="form-control-custom" placeholder="Masukkan latitude (lintang)" value="{{ $umkm->latitude }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label-custom">Longitude</label>
            <input type="text" name="longitude" class="form-control-custom" placeholder="Masukkan longitude (bujur)" value="{{ $umkm->longitude }}" required>
          </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-5">
          <button type="button" class="btn btn-batal" onclick="goToStep(1)">Sebelumnya</button>
          <button type="button" class="btn btn-selanjutnya" onclick="validasiDanLanjut(2, 3)">Selanjutnya</button>
        </div>
      </div>

      <div id="content-step-3" style="display: none;">
        <p class="info-text mb-4">Setelah melakukan pengecekan data, pilih status verifikasi data sesuai dengan kondisi UMKM.</p>

        <div class="mb-3" style="max-width: 350px;">
          <label class="form-label-custom">Nama UMKM</label>
          <input type="text" class="form-control-readonly" value="{{ $umkm->nama }}" readonly>
        </div>

        <div class="mb-4">
          <label class="form-label-custom mb-2">Status Verifikasi Data UMKM</label>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_verif" id="verif_disetujui" value="disetujui" {{ $umkm->status_verif == 'disetujui' ? 'checked' : '' }} required>
            <label class="form-check-label" for="verif_disetujui">Disetujui</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_verif" id="verif_menunggu" value="menunggu" {{ $umkm->status_verif == 'menunggu' ? 'checked' : '' }} required>
            <label class="form-check-label" for="verif_menunggu">Menunggu</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_verif" id="verif_ditolak" value="ditolak" {{ $umkm->status_verif == 'ditolak' ? 'checked' : '' }} required>
            <label class="form-check-label" for="verif_ditolak">Ditolak</label>
          </div>
        </div>

        <div id="box-catatan" class="mt-4" style="display: none; background-color: var(--color-orange-50); border: 1px solid #D17A22; padding: 16px; border-radius: 8px;">
          <label class="form-label-custom mb-2" style="color: #D17A22;">Alasan Penolakan <span style="color: #D17A22;">*</span></label>
          <textarea name="catatan_penolakan" id="input-catatan" class="form-control-custom" rows="3" placeholder="Tuliskan secara jelas mengapa data UMKM ini ditolak..." required></textarea>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-5">
          <div class="d-flex justify-content-end gap-2 mt-5">
            <button type="button" class="btn btn-batal" onclick="goToStep(2)">Sebelumnya</button>
            <button type="button" class="btn btn-selanjutnya" id="btn-next-step-3" onclick="goToStep(4)">Selanjutnya</button>
          </div>
        </div>
      </div>

      <div id="content-step-4" style="display: none;">
        <p class="info-text mb-4">Pilih status keaktifan UMKM.</p>

        <div class="mb-3" style="max-width: 350px;">
          <label class="form-label-custom">Nama UMKM</label>
          <input type="text" class="form-control-readonly" value="{{ $umkm->nama }}" readonly>
        </div>

        <div class="mb-4">
          <label class="form-label-custom mb-2">Status UMKM</label>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_umkm" id="aktif_ya" value="aktif" {{ $umkm->status_umkm == 'aktif' ? 'checked' : '' }} required>
            <label class="form-check-label" for="aktif_ya">Aktif</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_umkm" id="aktif_tidak" value="tidak" {{ $umkm->status_umkm == 'tidak' ? 'checked' : '' }} required>
            <label class="form-check-label" for="aktif_tidak">Tidak Aktif</label>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-5">
          <button type="button" class="btn btn-batal" onclick="goToStep(3)">Sebelumnya</button>
          <button type="submit" class="btn btn-selanjutnya">Simpan</button>
        </div>
      </div>
  </form>
</div>

<script>
  function goToStep(stepNumber) {
    // 1. Sembunyikan semua konten
    document.getElementById('content-step-1').style.display = 'none';
    document.getElementById('content-step-2').style.display = 'none';
    document.getElementById('content-step-3').style.display = 'none';
    document.getElementById('content-step-4').style.display = 'none';

    // 2. Tampilkan konten yang dipilih
    document.getElementById('content-step-' + stepNumber).style.display = 'block';

    // 3. Ubah Judul Halaman
    const titleElement = document.getElementById('step-title');
    if (stepNumber === 1) titleElement.innerText = 'Verifikasi Data UMKM';
    if (stepNumber === 2) titleElement.innerText = 'Input Titik Koordinat UMKM';
    if (stepNumber === 3) titleElement.innerText = 'Ubah Status Verifikasi Data UMKM';
    if (stepNumber === 4) titleElement.innerText = 'Ubah Status UMKM';

    // 4. Update UI Stepper (Warna, Centang, Garis)
    for (let i = 1; i <= 4; i++) {
      let stepDiv = document.getElementById('stepper-' + i);
      stepDiv.classList.remove('step-active', 'step-completed');

      let circle = stepDiv.querySelector('.step-circle');
      circle.innerHTML = i; // Kembalikan ke angka bawaan

      if (i < stepNumber) {
        // Sudah dilewati
        stepDiv.classList.add('step-completed');
        circle.innerHTML = '<iconify-icon icon="lucide:check" style="font-size: 18px;"></iconify-icon>';
      } else if (i === stepNumber) {
        // Sedang dibuka
        stepDiv.classList.add('step-active');
      }
    }
  }

  // FUNGSI GANTI FOTO (Tambahkan di bawah script goToStep)
  const fotoPreviewBox = document.getElementById('foto-preview-box');
  const inputNewFoto = document.getElementById('input-new-foto');
  const fotoPreviewImg = document.getElementById('foto-preview-img');

  if (fotoPreviewBox) {
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

    // ==========================================
    // FUNGSI UNTUK DROPDOWN KUSTOM
    // ==========================================
    function pilihDropdown(tipe, id, label, event) {
      event.preventDefault(); // Mencegah halaman melompat ke atas

      // 1. Ubah teks pada tombol agar terlihat sudah dipilih
      const labelElement = document.getElementById('label-' + tipe);
      labelElement.innerText = label;
      labelElement.classList.remove('text-muted');
      labelElement.style.color = 'var(--color-black)';

      // 2. Isi nilai ke input rahasia untuk dikirim ke database
      document.getElementById('input-' + tipe).value = id;

      // 3. Hilangkan efek error validasi seketika jika sebelumnya kosong
      const btnVisual = document.getElementById('btn-' + tipe);
      btnVisual.style.borderColor = '#E5E7EB';
      btnVisual.style.backgroundColor = '#FFFFFF';

      const errorText = btnVisual.parentNode.querySelector('.pesan-error-wajib');
      if (errorText) errorText.remove();
    }

    // Mengembalikan nilai dropdown jika gagal submit (validasi backend error)
    document.addEventListener('DOMContentLoaded', function() {
      @if(old('id_kategori'))
      const oldKatName = "{{ $kategoris->firstWhere('id', old('id_kategori'))->kategori_umkm ?? 'Pilih Kategori UMKM' }}";
      document.getElementById('label-kategori').innerText = oldKatName;
      document.getElementById('label-kategori').classList.remove('text-muted');
      document.getElementById('label-kategori').style.color = 'var(--color-black)';
      @endif

      @if(old('id_kelurahan'))
      const oldKelName = "{{ $kelurahans->firstWhere('id', old('id_kelurahan'))->nama_kelurahan ?? 'Pilih Kelurahan UMKM' }}";
      document.getElementById('label-kelurahan').innerText = oldKelName;
      document.getElementById('label-kelurahan').classList.remove('text-muted');
      document.getElementById('label-kelurahan').style.color = 'var(--color-black)';
      @endif
    });

    // ==========================================
    // FUNGSI VALIDASI FORM SEBELUM PINDAH STEP
    // ==========================================
    function validasiStep(stepSekarang) {
      const areaStep = document.getElementById('content-step-' + stepSekarang);
      const fieldWajib = areaStep.querySelectorAll('input[required], select[required], textarea[required]');
      let semuaValid = true;

      fieldWajib.forEach(field => {
        if (field.type === 'radio') return; // Radio button aman dari error visual ini

        const isCustomDropdown = field.id === 'input-kategori' || field.id === 'input-kelurahan';
        let targetVisual = field;

        // Tentukan target yang akan diberi kotak merah
        if (isCustomDropdown) targetVisual = document.getElementById('btn-' + field.id.replace('input-', ''));

        const tempatPesan = targetVisual;
        let errorText = tempatPesan.parentNode.querySelector('.pesan-error-wajib');

        if (field.value.trim() === '') {
          semuaValid = false;
          targetVisual.style.borderColor = '#D17A22';

          // Buat teks peringatan jika belum ada
          if (!errorText) {
            errorText = document.createElement('small');
            errorText.className = 'pesan-error-wajib';
            errorText.style.cssText = 'color: #D17A22; font-size: 12px; margin-top: 4px; display: block; font-weight: 500;';
            errorText.innerText = '*Wajib diisi';
            tempatPesan.parentNode.insertBefore(errorText, tempatPesan.nextSibling);
          }
        } else {
          // Kembalikan ke normal jika sudah diisi
          targetVisual.style.borderColor = '#E5E7EB';
          if (errorText) errorText.remove();
        }
      });

      return semuaValid;
    }

    // Fungsi pemicu tombol Selanjutnya
    function validasiDanLanjut(stepSekarang, stepTujuan) {
      if (validasiStep(stepSekarang)) {
        goToStep(stepTujuan);
      }
    }

    // Bonus UX: Menghilangkan peringatan merah seketika saat diketik
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('input[required], textarea[required]').forEach(field => {
        if (field.type === 'radio' || field.type === 'hidden') return;
        field.addEventListener('input', function() {
          if (this.value.trim() !== '') {
            this.style.borderColor = '#E5E7EB';
            const errorText = this.parentNode.querySelector('.pesan-error-wajib');
            if (errorText) errorText.remove();
          }
        });
      });
    });


    // ==========================================
    // LOGIKA DINAMIS TAHAP 3 (JIKA DITOLAK = LANGSUNG SIMPAN)
    // ==========================================
    const radiosVerif = document.querySelectorAll('input[name="status_verif"]');
    const btnNextStep3 = document.getElementById('btn-next-step-3');
    const formVerifikasi = document.getElementById('form-verifikasi');
    const stepper4 = document.getElementById('stepper-4');
    const boxCatatan = document.getElementById('box-catatan');
    const inputCatatan = document.getElementById('input-catatan');

    function perbaruiTombolStep3() {
      const radioTerpilih = document.querySelector('input[name="status_verif"]:checked');

      if (radioTerpilih && radioTerpilih.value === 'ditolak') {
        // JIKA DITOLAK
        btnNextStep3.innerHTML = 'Simpan & Tolak';
        btnNextStep3.style.backgroundColor = '#D17A22';
        btnNextStep3.style.borderColor = '#D17A22';
        btnNextStep3.style.color = '#FFFFFF';
        btnNextStep3.onclick = function() {
          formVerifikasi.submit();
        };
        stepper4.style.opacity = '0.4';
        boxCatatan.style.display = 'block';
        inputCatatan.setAttribute('required', 'required');

      } else {
        // JIKA DISETUJUI / MENUNGGU
        btnNextStep3.innerHTML = 'Selanjutnya';
        btnNextStep3.style.backgroundColor = '';
        btnNextStep3.style.borderColor = '';
        btnNextStep3.onclick = function() {
          goToStep(4);
        };
        stepper4.style.opacity = '1';
        boxCatatan.style.display = 'none';
        inputCatatan.removeAttribute('required');
        inputCatatan.value = '';
      }
    }

    // 1. Jalankan sekali saat halaman pertama kali dimuat (berjaga-jaga jika ada old() value)
    perbaruiTombolStep3();

    // 2. Pasang 'telinga' (listener) ke setiap pilihan radio. 
    // Setiap kali pengguna klik pilihan yang berbeda, jalankan fungsinya.
    radiosVerif.forEach(radio => {
      radio.addEventListener('change', perbaruiTombolStep3);
    });
  }
</script>

@if(session('wa_rejected'))
@php
$wa_data = session('wa_rejected');

// 1. Bersihkan nomor HP dari karakter selain angka
$nomor_hp = preg_replace('/[^0-9]/', '', $wa_data['kontak']);

// 2. Ubah angka 0 di depan menjadi 62 (Kode Negara Indonesia)
if (str_starts_with($nomor_hp, '0')) {
$nomor_hp = '62' . substr($nomor_hp, 1);
}

// 3. Susun isi pesan WhatsApp
$pesan = "Halo, kami dari Admin SI Data UMKM Kecamatan Bacukiki.\n\n";
$pesan .= "Mohon maaf, pendaftaran data untuk UMKM *{$wa_data['nama']}* saat ini belum dapat kami setujui.\n";
$pesan .= "*Alasan Penolakan:* {$wa_data['catatan_penolakan']}\n\n";
$pesan .= "Silakan perbaiki data Anda dan lakukan pengajuan ulang melalui tautan berikut:\n";
$pesan .= "https://forms.gle/Bu7sdaRdWGAXTXUn6\n\n";
$pesan .= "Terima kasih.";

// 4. Encode URL pesan agar aman dikirim lewat link
$link_wa = "https://wa.me/" . $nomor_hp . "?text=" . urlencode($pesan);
@endphp

<div class="modal fade" id="waSuccessModal" tabindex="-1" aria-labelledby="waSuccessModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 12px; border: none;">
      <div class="modal-body text-center p-5">
        <div class="mb-4">
          <iconify-icon icon="lucide:check-circle-2" style="font-size: 64px; color: var(--color-green);"></iconify-icon>
        </div>
        <h4 class="mb-2" style="font-weight: 700; color: var(--color-black);">Verifikasi Selesai</h4>
        <p class="mb-4" style="color: var(--color-gray); font-size: 14px;">
          Data UMKM <strong>{{ $wa_data['nama'] }}</strong> telah disimpan dengan status Ditolak. Silakan hubungi pemilik UMKM untuk memberitahukan alasan penolakan.
        </p>
        <div class="d-flex justify-content-center gap-3">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Tutup</button>
          <a href="{{ $link_wa }}" target="_blank" class="btn text-white d-flex align-items-center gap-2" style="border-radius: 8px; font-weight: 500; background-color: #41644A; border: none;">
            <iconify-icon icon="lucide:message-circle" style="font-size: 18px;"></iconify-icon>
            Kirim Pesan WhatsApp
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Script untuk memunculkan modal secara otomatis jika ada session wa_rejected
  document.addEventListener("DOMContentLoaded", function() {
    var waModal = new bootstrap.Modal(document.getElementById('waSuccessModal'));
    waModal.show();
  });
</script>
@endif
@endsection