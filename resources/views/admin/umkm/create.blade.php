@extends('layouts.app')

<!-- HALAMAN INPUT DATA MANUAL -->

@section('content')
<style>
  /* === STYLING CARD UTAMA === */
  .create-card {
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
    font-size: 14px;
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

  /* === FORM & GAMBAR STYLING === */
  .info-text {
    font-size: 14px;
    color: var(--color-black);
    line-height: 1.5;
  }

  .foto-edit-container {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 280px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.2s;
    border: 2px dashed #CBD5E1;
    /* Border putus-putus untuk area upload baru */
    background-color: #F8FAFC;
  }

  .foto-edit-container:hover {
    opacity: 0.9;
    border-color: var(--color-green);
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
    font-size: 13px;
    font-weight: 500;
    color: var(--color-black);
    margin-bottom: 6px;
  }

  .form-control-custom,
  .form-select-custom {
    border-radius: 6px;
    border: 1px solid #9CA3AF;
    font-size: 13px;
    color: var(--color-black);
    padding: 10px 14px;
    width: 100%;
    transition: border-color 0.2s;
  }

  .form-control-custom:focus,
  .form-select-custom:focus {
    border-color: var(--color-green);
    box-shadow: 0 0 0 0.15rem var(--color-green-light);
    outline: none;
  }

  .form-control-custom::placeholder {
    color: #9CA3AF;
  }

  /* Radio Buttons */
  .form-check-label {
    font-size: 13px;
    color: var(--color-black);
    cursor: pointer;
  }

  /* Mengubah warna saat radio button dipilih */
  .form-check-input:checked {
    background-color: var(--color-green) !important;
    border-color: var(--color-green) !important;
  }

  /* Mengubah warna bayangan (glow) saat radio button diklik/fokus */
  .form-check-input:focus {
    border-color: var(--color-green) !important;
    box-shadow: 0 0 0 0.25rem rgba(65, 109, 80, 0.25) !important;
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

  /* CSS MOBILE */
  @media (max-width: 768px) {

    /* 3. Dropdown group juga mengambil sisa lebar penuh di baris kedua */
    .dropdown-group {
      display: flex;
      flex-wrap: nowrap;
      /* Pertahankan sejajar di HP */
      justify-content: center;
      width: 100%;
      gap: 10px;
    }

    /* 4. Kedua dropdown membagi sisa ruang secara adil (50:50) */
    .form-select-custom {
      flex: 1;
      /* Perintah agar lebarnya seimbang */
      min-width: 0;
      /* Mencegah elemen keluar batas layar jika terlalu kecil */
      font-size: 13px;
      padding: 8px 28px 8px 12px;
      background-position: right 8px center;
    }
  }
</style>

<div class="container-fluid p-3 p-md-4">

  <form action="{{ route('umkm.store') }}" method="POST" id="form-create" enctype="multipart/form-data">
    @csrf

    <div class="create-card">
      <h3 id="step-title" style="font-size: 20px; font-weight: 700; color: var(--color-black); margin-bottom: 30px;">Input Data UMKM</h3>

      <div class="stepper-container" id="stepper">
        <div class="step-item step-active" id="stepper-1">
          <div class="step-circle">1</div>
          <span class="step-text">Input Data</span>
        </div>
        <div class="step-item" id="stepper-2">
          <div class="step-circle">2</div>
          <span class="step-text">Input Koordinat</span>
        </div>
        <!-- <div class="step-item" id="stepper-3">
          <div class="step-circle">3</div>
          <span class="step-text">Status Verifikasi</span>
        </div> -->
        <div class="step-item" id="stepper-3">
          <div class="step-circle">3</div>
          <span class="step-text">Status UMKM</span>
        </div>
      </div>

      @if ($errors->any())
      <div class="alert alert-danger" style="border-radius: 8px; font-size: 13px; border:none; background-color:rgba(211,47,47,0.1); color:#D32F2F">
        <strong>Gagal Menyimpan Data!</strong> Silakan periksa kembali isian Anda:
        <ul class="mb-0 mt-1">
          @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
      </div>
      @endif

      <div id="content-step-1">
        <p class="info-text mb-4">Lengkapi data informasi dasar UMKM di bawah ini.</p>
        <div class="row g-4 mb-4">
          <div class="col-lg-4">
            <div class="foto-edit-container" id="foto-preview-box">
              <div class="foto-overlay-edit">Tekan untuk menambahkan foto</div>
              <img src="https://via.placeholder.com/800x600?text=Upload+Foto+UMKM" id="foto-preview-img">
            </div>
            <input type="file" name="new_foto" id="input-new-foto" style="display: none;" accept="image/jpeg,image/png,image/jpg" required>
          </div>

          <div class="col-lg-8">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label-custom">Nama UMKM</label>
                <input type="text" name="nama" class="form-control-custom" placeholder="contoh: Warung Berkah" value="{{ old('nama') }}" required>
              </div>
              <div class="col-md-6">
                <label class="form-label-custom">Kontak UMKM</label>
                <input type="text" id="kontak" name="kontak" class="form-control-custom" placeholder="contoh: 081234567890" value="{{ old('kontak') }}" required>
              </div>
              <div class="col-md-6">
                <label class="form-label-custom">Kategori UMKM</label>
                <div class="dropdown w-100">
                  <button class="btn form-control-custom w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="btn-kategori" style="background-color: #FFFFFF;">
                    <span id="label-kategori" class="text-truncate text-muted">Pilih Kategori UMKM</span>
                    <iconify-icon icon="lucide:chevron-down" style="color: #9CA3AF; min-width: 16px;"></iconify-icon>
                  </button>
                  <ul class="dropdown-menu w-100 shadow-sm" style="border-radius: 8px; font-size: 13px; border: 1px solid #E5E7EB; padding: 8px 0; max-height: 250px; overflow-y: auto;">
                    @foreach($kategoris as $kategori)
                    <li><a class="dropdown-item py-2" href="#" onclick="pilihDropdown('kategori', '{{ $kategori->id }}', '{{ $kategori->kategori_umkm }}', event)">{{ $kategori->kategori_umkm }}</a></li>
                    @endforeach
                  </ul>
                  <input type="text" name="id_kategori" id="input-kategori" value="{{ old('id_kategori') }}" style="opacity: 0; position: absolute; z-index: -1; width: 1px; height: 1px;" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label-custom">Kelurahan UMKM</label>
                <div class="dropdown w-100">
                  <button class="btn form-control-custom w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="btn-kelurahan" style="background-color: #FFFFFF;">
                    <span id="label-kelurahan" class="text-truncate text-muted">Pilih Kelurahan UMKM</span>
                    <iconify-icon icon="lucide:chevron-down" style="color: #9CA3AF; min-width: 16px;"></iconify-icon>
                  </button>
                  <ul class="dropdown-menu w-100 shadow-sm" style="border-radius: 8px; font-size: 13px; border: 1px solid #E5E7EB; padding: 8px 0; max-height: 250px; overflow-y: auto;">
                    @foreach($kelurahans as $kelurahan)
                    <li><a class="dropdown-item py-2" href="#" onclick="pilihDropdown('kelurahan', '{{ $kelurahan->id }}', '{{ $kelurahan->nama_kelurahan }}', event)">{{ $kelurahan->nama_kelurahan }}</a></li>
                    @endforeach
                  </ul>
                  <input type="text" name="id_kelurahan" id="input-kelurahan" value="{{ old('id_kelurahan') }}" style="opacity: 0; position: absolute; z-index: -1; width: 1px; height: 1px;" required>
                </div>
              </div>
              <div class="col-12">
                <label class="form-label-custom">Alamat UMKM</label>
                <input type="text" name="alamat" class="form-control-custom" placeholder="contoh: Jl. Seroja No. 1" value="{{ old('alamat') }}" required>
              </div>
              <div class="col-12">
                <label class="form-label-custom">Link Titik Lokasi UMKM (Google Maps)</label>
                <input type="url" name="titik_maps" class="form-control-custom" placeholder="contoh: https://maps.app.goo.gl/nC9mG2kyBvKESyn76" value="{{ old('titik_maps') }}" required>
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="{{ route('umkm.index') }}" class="btn btn-batal">Batal</a>
          <button type="button" class="btn btn-selanjutnya" onclick="validasiDanLanjut(1, 2)">Selanjutnya</button>
        </div>
      </div>

      <div id="content-step-2" style="display: none;">
        <p class="info-text mb-4">Silakan input titik koordinat lokasi UMKM.</p>
        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <label class="form-label-custom">Latitude</label>
            <input type="text" name="latitude" class="form-control-custom" placeholder="contoh: -4.014483594504468" value="{{ old('latitude') }}" inputmode="decimal" required>
          </div>
          <div class="col-md-6">
            <label class="form-label-custom">Longitude</label>
            <input type="text" name="longitude" class="form-control-custom" placeholder="contoh: 119.65160926671558" value="{{ old('longitude') }}" inputmode="decimal" required>
          </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-5">
          <button type="button" class="btn btn-batal" onclick="goToStep(1)">Sebelumnya</button>
          <button type="button" class="btn btn-selanjutnya" onclick="validasiDanLanjut(2, 3)">Selanjutnya</button>
        </div>
      </div>

      <!-- <div id="content-step-3" style="display: none;">
        <p class="info-text mb-4">Pilih status verifikasi data sesuai dengan kondisi UMKM.</p>
        <div class="mb-4">
          <label class="form-label-custom mb-2">Status Verifikasi Data UMKM</label>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_verif" id="verif_disetujui" value="disetujui" {{ old('status_verif') == 'disetujui' ? 'checked' : '' }} required>
            <label class="form-check-label" for="verif_disetujui">Disetujui</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_verif" id="verif_menunggu" value="menunggu" {{ old('status_verif', 'menunggu') == 'menunggu' ? 'checked' : '' }} required>
            <label class="form-check-label" for="verif_menunggu">Menunggu</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_verif" id="verif_ditolak" value="ditolak" {{ old('status_verif') == 'ditolak' ? 'checked' : '' }} required>
            <label class="form-check-label" for="verif_ditolak">Ditolak</label>
          </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-5">
          <button type="button" class="btn btn-batal" onclick="goToStep(2)">Sebelumnya</button>
          <button type="button" class="btn btn-selanjutnya" onclick="validasiDanLanjut(3, 4)">Selanjutnya</button>
        </div>
      </div> -->

      <div id="content-step-3" style="display: none;">
        <p class="info-text mb-4">Pilih status keaktifan UMKM.</p>
        <div class="mb-4">
          <label class="form-label-custom mb-2">Status UMKM</label>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_umkm" id="aktif_ya" value="aktif" {{ old('status_umkm', 'aktif') == 'aktif' ? 'checked' : '' }} required>
            <label class="form-check-label" for="aktif_ya">Aktif</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="status_umkm" id="aktif_tidak" value="tidak" {{ old('status_umkm') == 'tidak' ? 'checked' : '' }} required>
            <label class="form-check-label" for="aktif_tidak">Tidak Aktif</label>
          </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-5">
          <button type="button" class="btn btn-batal" onclick="goToStep(2)">Sebelumnya</button>
          <button type="submit" class="btn btn-selanjutnya">Simpan</button>
        </div>
      </div>

    </div>
  </form>

</div>

<script>
  // ==========================================
  // 1. FUNGSI GANTI TAHAP STEPPER
  // ==========================================
  function goToStep(stepNumber) {
    document.getElementById('content-step-1').style.display = 'none';
    document.getElementById('content-step-2').style.display = 'none';
    document.getElementById('content-step-3').style.display = 'none';

    document.getElementById('content-step-' + stepNumber).style.display = 'block';

    const titleElement = document.getElementById('step-title');
    if (stepNumber === 1) titleElement.innerText = 'Input Data UMKM';
    if (stepNumber === 2) titleElement.innerText = 'Input Titik Koordinat UMKM';
    if (stepNumber === 3) titleElement.innerText = 'Pilih Status UMKM';

    for (let i = 1; i <= 3; i++) {
      let stepDiv = document.getElementById('stepper-' + i);
      stepDiv.classList.remove('step-active', 'step-completed');

      let circle = stepDiv.querySelector('.step-circle');
      circle.innerHTML = i;

      if (i < stepNumber) {
        stepDiv.classList.add('step-completed');
        circle.innerHTML = '<iconify-icon icon="lucide:check" style="font-size: 18px;"></iconify-icon>';
      } else if (i === stepNumber) {
        stepDiv.classList.add('step-active');
      }
    }
  }

  // ==========================================
  // 2. FUNGSI PREVIEW FOTO BARU
  // ==========================================
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
          fotoPreviewBox.style.border = 'none';
        }
        reader.readAsDataURL(file);
      }
    });
  }

  // ==========================================
  // 3. FUNGSI RESTRIKSI & VALIDASI KONTAK
  // ==========================================
  const kontak = document.getElementById('kontak');
  if (kontak) {
    kontak.addEventListener('input', function() {
      // a. Hapus semua karakter yang BUKAN angka seketika saat diketik
      this.value = this.value.replace(/[^0-9]/g, '');

      // b. Batasi maksimal 15 karakter
      if (this.value.length > 15) {
        this.value = this.value.slice(0, 15);
      }

      // c. Validasi awalan dan jumlah minimal digit
      const nomor = this.value;
      if (nomor.length === 0) {
        this.setCustomValidity(''); // Biarkan HTML5 'required' yang menangani ini
      } else if (!nomor.startsWith('08') && !nomor.startsWith('628')) {
        this.setCustomValidity('Nomor WA harus diawali 08 atau 628.');
      } else if (nomor.length < 10) {
        this.setCustomValidity('Nomor WA minimal 10 digit.');
      } else {
        this.setCustomValidity(''); // Valid
      }
    });
  }

  // ==========================================
  // 4. FUNGSI VALIDASI SEBELUM PINDAH TAHAP
  // ==========================================
  function validasiDanLanjut(stepSekarang, stepTujuan) {
    const areaStep = document.getElementById('content-step-' + stepSekarang);
    const fieldWajib = areaStep.querySelectorAll('input[required], select[required], textarea[required]');

    let semuaValid = true;

    fieldWajib.forEach(field => {
      const isFoto = field.type === 'file';
      const isCustomDropdown = field.id === 'input-kategori' || field.id === 'input-kelurahan';

      // Tentukan elemen mana yang akan diwarnai
      let targetVisual = field;
      if (isFoto) targetVisual = document.getElementById('foto-preview-box');
      if (isCustomDropdown) targetVisual = document.getElementById('btn-' + field.id.replace('input-', ''));

      // Cari elemen pesan error (jika sudah ada sebelumnya)
      let errorText = targetVisual.parentNode.querySelector('.pesan-error-wajib');

      if (!field.checkValidity()) {
        // ==========================================
        // JIKA GAGAL VALIDASI
        // ==========================================
        semuaValid = false;

        // 1. Ubah warna border (Oranye)
        targetVisual.style.borderColor = '#D17A22';

        // 2. Buat elemen teks error JIKA belum ada
        if (!errorText) {
          errorText = document.createElement('small');
          errorText.className = 'pesan-error-wajib';
          errorText.style.cssText = 'color: #D17A22; font-size: 12px; margin-top: 4px; display: block; font-weight: 500;';
          targetVisual.parentNode.insertBefore(errorText, targetVisual.nextSibling);
        }

        // 3. Tentukan isi pesannya
        if (field.validity.valueMissing) {
          errorText.innerText = '*Wajib diisi';
        } else if (field.id === 'kontak' && field.validationMessage) {
          errorText.innerText = '*' + field.validationMessage;
        } else {
          errorText.innerText = '*Format tidak sesuai';
        }

      } else {
        // ==========================================
        // JIKA VALID (TERISI BENAR)
        // ==========================================
        targetVisual.style.borderColor = '#E5E7EB';
        targetVisual.style.backgroundColor = isFoto ? 'transparent' : '#FFFFFF';

        // Hapus teks error jika sebelumnya ada
        if (errorText) {
          errorText.remove();
        }
      }
    });

    // Pindah step jika tidak ada error sama sekali
    if (semuaValid) {
      goToStep(stepTujuan);
    }
  }

  // ==========================================
  // 5. FUNGSI UNTUK DROPDOWN KUSTOM
  // ==========================================
  function pilihDropdown(tipe, id, label, event) {
    event.preventDefault();

    const labelElement = document.getElementById('label-' + tipe);
    labelElement.innerText = label;
    labelElement.classList.remove('text-muted');
    labelElement.style.color = 'var(--color-black)';

    document.getElementById('input-' + tipe).value = id;

    const btnVisual = document.getElementById('btn-' + tipe);
    btnVisual.style.borderColor = '#E5E7EB';
    btnVisual.style.backgroundColor = '#FFFFFF';

    const errorText = btnVisual.parentNode.querySelector('.pesan-error-wajib');
    if (errorText) errorText.remove();
  }

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
  // 6. HILANGKAN ERROR SEKETIKA SAAT DIKETIK
  // ==========================================
  document.addEventListener('DOMContentLoaded', function() {
    const semuaFieldWajib = document.querySelectorAll('input[required], select[required], textarea[required]');

    semuaFieldWajib.forEach(field => {
      const eventType = (field.type === 'file' || field.tagName === 'SELECT') ? 'change' : 'input';

      field.addEventListener(eventType, function() {
        if (this.checkValidity()) {
          const isFoto = this.type === 'file';
          const isCustomDropdown = this.id === 'input-kategori' || this.id === 'input-kelurahan';

          let targetVisual = this;
          if (isFoto) targetVisual = document.getElementById('foto-preview-box');
          if (isCustomDropdown) targetVisual = document.getElementById('btn-' + this.id.replace('input-', ''));

          targetVisual.style.borderColor = '#E5E7EB';
          targetVisual.style.backgroundColor = isFoto ? 'transparent' : '#FFFFFF';

          const errorText = targetVisual.parentNode.querySelector('.pesan-error-wajib');
          if (errorText) errorText.remove();
        }
      });
    });
  });
</script>

<!-- <script>
  // FUNGSI GANTI TAHAP STEPPER
  function goToStep(stepNumber) {
    document.getElementById('content-step-1').style.display = 'none';
    document.getElementById('content-step-2').style.display = 'none';
    // document.getElementById('content-step-3').style.display = 'none';
    document.getElementById('content-step-3').style.display = 'none';

    document.getElementById('content-step-' + stepNumber).style.display = 'block';

    const titleElement = document.getElementById('step-title');
    if (stepNumber === 1) titleElement.innerText = 'Input Data UMKM';
    if (stepNumber === 2) titleElement.innerText = 'Input Titik Koordinat UMKM';
    // if (stepNumber === 3) titleElement.innerText = 'Pilih Status Verifikasi Data UMKM';
    if (stepNumber === 3) titleElement.innerText = 'Pilih Status UMKM';

    for (let i = 1; i <= 3; i++) {
      let stepDiv = document.getElementById('stepper-' + i);
      stepDiv.classList.remove('step-active', 'step-completed');

      let circle = stepDiv.querySelector('.step-circle');
      circle.innerHTML = i;

      if (i < stepNumber) {
        stepDiv.classList.add('step-completed');
        circle.innerHTML = '<iconify-icon icon="lucide:check" style="font-size: 18px;"></iconify-icon>';
      } else if (i === stepNumber) {
        stepDiv.classList.add('step-active');
      }
    }
  }

  // FUNGSI PREVIEW FOTO BARU
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
          // Menghilangkan styling border dashed saat foto sudah dipilih
          fotoPreviewBox.style.border = 'none';
        }
        reader.readAsDataURL(file);
      }
    });
  }

  // Fungsi untuk validasi input kontak
  const kontak = document.getElementById('kontak');
  kontak.addEventListener('input', function() {
    const nomor = this.value;
    const regex = /^(08|628)[0-9]{8,12}$/; // diawali 08 atau 628, hanya angka, stlh awalan 8-12 digit

    if (nomor.length === 0) {
      this.setCustomValidity('');
    } else if (!regex.test(nomor)) {
      this.setCustomValidity(
        'Nomor WhatsApp harus diawali 08 atau 628 dan terdiri dari 10-15 digit.'
      );
    } else {
      this.setCustomValidity('');
    }
  });

  // Fungsi untuk memvalidasi sebelum pindah tahap
  function validasiDanLanjut(stepSekarang, stepTujuan) {
    const areaStep = document.getElementById('content-step-' + stepSekarang);
    const fieldWajib = areaStep.querySelectorAll('input[required], select[required], textarea[required]');

    let semuaValid = true;

    fieldWajib.forEach(field => {
      // Tentukan target yang akan diwarnai 
      const isFoto = field.type === 'file';
      const isCustomDropdown = field.id === 'input-kategori' || field.id === 'input-kelurahan';

      let targetVisual = field;
      if (isFoto) targetVisual = document.getElementById('foto-preview-box');
      if (isCustomDropdown) targetVisual = document.getElementById('btn-' + field.id.replace('input-', ''));

      // Cari lokasi tempat teks error akan disisipkan
      const tempatPesan = targetVisual;
      let errorText = tempatPesan.parentNode.querySelector('.pesan-error-wajib');

      if (!field.checkValidity()) {
        // ==========================================
        // JIKA KOSONG: Gagal validasi
        // ==========================================
        semuaValid = false;

        // 1. Ubah warna border & background (Warna Oranye/Merah Bata)
        targetVisual.style.borderColor = '#D17A22';

        // 2. Buat dan munculkan teks *Wajib diisi jika belum ada
        if (field.validity.valueMissing) {
          errorText.innerText = '*Wajib diisi';
          errorText = document.createElement('small');
          errorText.className = 'pesan-error-wajib';
          errorText.style.cssText = 'color: #D17A22; font-size: 12px; margin-top: 4px; display: block; font-weight: 500;';
          tempatPesan.parentNode.insertBefore(errorText, tempatPesan.nextSibling);

        } else if (field.name === 'kontak') {
          errorText.innerText = '*Nomor WA harus diawali 08 atau 628.';
          errorText = document.createElement('small');
          errorText.style.cssText = 'color: #D17A22; font-size: 12px; margin-top: 4px; display: block; font-weight: 500;';
          tempatPesan.parentNode.insertBefore(errorText, tempatPesan.nextSibling);

        } else {
          errorText.innerText = field.validationMessage;
        }

      } else {
        // ==========================================
        // JIKA TERISI: Kembalikan ke normal
        // ==========================================
        targetVisual.style.borderColor = '#E5E7EB'; // Warna border abu-abu standar
        targetVisual.style.backgroundColor = isFoto ? 'transparent' : '#FFFFFF';

        // Hapus teks error
        if (errorText) {
          errorText.remove();
        }
      }
    });

    // Keputusan akhir untuk pindah step
    if (semuaValid) {
      goToStep(stepTujuan);
    }
  }

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
  // BONUS UX: Hilangkan error seketika saat diketik/diisi
  // ==========================================
  document.addEventListener('DOMContentLoaded', function() {
    const semuaFieldWajib = document.querySelectorAll('input[required], select[required], textarea[required]');

    semuaFieldWajib.forEach(field => {
      // Gunakan event 'change' untuk file/select, 'input' untuk teks
      const eventType = (field.type === 'file' || field.tagName === 'SELECT') ? 'change' : 'input';

      field.addEventListener(eventType, function() {
        if (this.value.trim() !== '') {
          const isFoto = this.type === 'file';
          const targetVisual = isFoto ? document.getElementById('foto-preview-box') : this;
          const tempatPesan = isFoto ? targetVisual : this;

          // Kembalikan warna ke normal
          targetVisual.style.borderColor = '#E5E7EB';
          targetVisual.style.backgroundColor = isFoto ? 'transparent' : '#FFFFFF';

          // Hapus teks error jika ada
          const errorText = tempatPesan.parentNode.querySelector('.pesan-error-wajib');
          if (errorText) errorText.remove();
        }
      });
    });
  });
</script> -->
@endsection