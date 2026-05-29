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
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: 600;
    font-size: 14px;
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
</style>

<form action="{{ route('umkm.store') }}" method="POST" id="form-create" enctype="multipart/form-data">
  @csrf

  <div class="create-card">
    <h3 id="step-title" style="font-size: 20px; font-weight: 700; color: var(--color-black); margin-bottom: 30px;">Input Data UMKM</h3>
    <a href="{{ route('umkm.index') }}" class="btn-close-custom"><iconify-icon icon="lucide:x"></iconify-icon></a>

    <div class="stepper-container" id="stepper">
      <div class="step-item step-active" id="stepper-1">
        <div class="step-circle">1</div>
        <span class="step-text">Input Data</span>
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
              <input type="text" name="nama" class="form-control-custom" placeholder="Masukkan nama UMKM" value="{{ old('nama') }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label-custom">Kontak UMKM</label>
              <input type="text" name="kontak" class="form-control-custom" placeholder="Masukkan kontak UMKM" value="{{ old('kontak') }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label-custom">Kategori UMKM</label>
              <select name="id_kategori" class="form-select-custom" required>
                <option value="" disabled selected>Pilih Kategori UMKM</option>
                @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ old('id_kategori') == $kategori->id ? 'selected' : '' }}>{{ $kategori->kategori_umkm }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label-custom">Kelurahan UMKM</label>
              <select name="id_kelurahan" class="form-select-custom" required>
                <option value="" disabled selected>Pilih Kelurahan UMKM</option>
                @foreach($kelurahans as $kelurahan)
                <option value="{{ $kelurahan->id }}" {{ old('id_kelurahan') == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <label class="form-label-custom">Alamat UMKM</label>
              <input type="text" name="alamat" class="form-control-custom" placeholder="Masukkan alamat UMKM" value="{{ old('alamat') }}" required>
            </div>
            <div class="col-12">
              <label class="form-label-custom">Link Titik Lokasi UMKM (Google Maps)</label>
              <input type="url" name="titik_maps" class="form-control-custom" placeholder="Masukkan link titik lokasi UMKM" value="{{ old('titik_maps') }}" required>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('umkm.index') }}" class="btn btn-batal">Batal</a>
        <!-- <button type="button" class="btn btn-selanjutnya" onclick="goToStep(2)">Selanjutnya</button> -->
        <button type="button" class="btn btn-selanjutnya" onclick="validasiDanLanjut(1, 2)">Selanjutnya</button>
      </div>
    </div>

    <div id="content-step-2" style="display: none;">
      <p class="info-text mb-4">Silakan input titik koordinat lokasi UMKM.</p>
      <div class="row g-4 mb-4">
        <div class="col-md-6">
          <label class="form-label-custom">Latitude</label>
          <input type="text" name="latitude" class="form-control-custom" placeholder="Masukkan latitude (lintang)" value="{{ old('latitude') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label-custom">Longitude</label>
          <input type="text" name="longitude" class="form-control-custom" placeholder="Masukkan longitude (bujur)" value="{{ old('longitude') }}" required>
        </div>
      </div>
      <div class="d-flex justify-content-end gap-2 mt-5">
        <button type="button" class="btn btn-batal" onclick="goToStep(1)">Sebelumnya</button>
        <!-- <button type="button" class="btn btn-selanjutnya" onclick="goToStep(3)">Selanjutnya</button> -->
        <button type="button" class="btn btn-selanjutnya" onclick="validasiDanLanjut(2, 3)">Selanjutnya</button>
      </div>
    </div>

    <div id="content-step-3" style="display: none;">
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
        <!-- <button type="button" class="btn btn-selanjutnya" onclick="goToStep(4)">Selanjutnya</button> -->
        <button type="button" class="btn btn-selanjutnya" onclick="validasiDanLanjut(3, 4)">Selanjutnya</button>
      </div>
    </div>

    <div id="content-step-4" style="display: none;">
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
        <button type="button" class="btn btn-batal" onclick="goToStep(3)">Sebelumnya</button>
        <button type="submit" class="btn btn-selanjutnya">Simpan</button>
      </div>
    </div>

  </div>
</form>

<script>
  // FUNGSI GANTI TAHAP STEPPER
  function goToStep(stepNumber) {
    document.getElementById('content-step-1').style.display = 'none';
    document.getElementById('content-step-2').style.display = 'none';
    document.getElementById('content-step-3').style.display = 'none';
    document.getElementById('content-step-4').style.display = 'none';

    document.getElementById('content-step-' + stepNumber).style.display = 'block';

    const titleElement = document.getElementById('step-title');
    if (stepNumber === 1) titleElement.innerText = 'Input Data UMKM';
    if (stepNumber === 2) titleElement.innerText = 'Input Titik Koordinat UMKM';
    if (stepNumber === 3) titleElement.innerText = 'Pilih Status Verifikasi Data UMKM';
    if (stepNumber === 4) titleElement.innerText = 'Pilih Status UMKM';

    for (let i = 1; i <= 4; i++) {
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

  // Fungsi untuk memvalidasi sebelum pindah tahap
  // function validasiDanLanjut(stepSekarang, stepTujuan) {
  //   // 1. Ambil kotak area step saat ini (misal: content-step-1)
  //   const areaStep = document.getElementById('content-step-' + stepSekarang);

  //   // 2. Cari semua input/select yang memiliki atribut 'required' di dalam tahap tersebut
  //   const fieldWajib = areaStep.querySelectorAll('input[required], select[required], textarea[required]');

  //   let semuaValid = true;

  //   // 3. Cek satu per satu
  //   fieldWajib.forEach(field => {
  //     if (field.value.trim() === '') {
  //       // JIKA KOSONG: Gagalkan validasi dan ubah border jadi merah
  //       semuaValid = false;
  //       field.style.borderColor = 'var(--color-orange)'; // Warna merah
  //       // field.style.backgroundColor = 'var(--color-orange-50)'; // Background merah sangat muda (opsional)
  //     } else {
  //       // JIKA TERISI: Kembalikan warna border ke normal
  //       field.style.borderColor = '#E5E7EB';
  //       field.style.backgroundColor = '#FFFFFF';
  //     }
  //   });

  //   // 4. Keputusan Akhir
  //   if (semuaValid) {
  //     // Jika tidak ada yang kosong, silakan pindah ke tahap berikutnya
  //     goToStep(stepTujuan);
  //   } else {
  //     // (Opsional) Tampilkan peringatan jika ingin lebih tegas
  //     // alert('Terdapat data yang belum diisi. Silakan lengkapi kotak berwarna merah.');
  //   }
  // }

  // Fungsi untuk memvalidasi sebelum pindah tahap
  function validasiDanLanjut(stepSekarang, stepTujuan) {
    const areaStep = document.getElementById('content-step-' + stepSekarang);
    const fieldWajib = areaStep.querySelectorAll('input[required], select[required], textarea[required]');

    let semuaValid = true;

    fieldWajib.forEach(field => {
      // Tentukan target yang akan diwarnai (Khusus foto, targetkan kotak pembungkusnya)
      const isFoto = field.type === 'file';
      const targetVisual = isFoto ? document.getElementById('foto-preview-box') : field;

      // Cari lokasi tempat teks error akan disisipkan
      const tempatPesan = isFoto ? targetVisual : field;
      let errorText = tempatPesan.parentNode.querySelector('.pesan-error-wajib');

      if (field.value.trim() === '') {
        // ==========================================
        // JIKA KOSONG: Gagal validasi
        // ==========================================
        semuaValid = false;

        // 1. Ubah warna border & background (Warna Oranye/Merah Bata)
        targetVisual.style.borderColor = '#D17A22';
        // targetVisual.style.backgroundColor = '#FFFBEB';

        // 2. Buat dan munculkan teks *Wajib diisi jika belum ada
        if (!errorText) {
          errorText = document.createElement('small');
          errorText.className = 'pesan-error-wajib';
          errorText.style.cssText = 'color: #D17A22; font-size: 12px; margin-top: 4px; display: block; font-weight: 500;';
          errorText.innerText = '*Wajib diisi';

          // Sisipkan tepat di bawah elemen target
          tempatPesan.parentNode.insertBefore(errorText, tempatPesan.nextSibling);
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
  // ==========================================
  // BONUS UX: Hilangkan warna merah secara otomatis saat user mulai mengetik
  // ==========================================
  // document.addEventListener('DOMContentLoaded', function() {
  //   const semuaFieldWajib = document.querySelectorAll('input[required], select[required], textarea[required]');

  //   semuaFieldWajib.forEach(field => {
  //     field.addEventListener('input', function() {
  //       if (this.value.trim() !== '') {
  //         this.style.borderColor = '#E5E7EB'; // Kembali normal
  //         this.style.backgroundColor = '#FFFFFF';
  //       }
  //     });
  //   });
  // });
</script>
@endsection