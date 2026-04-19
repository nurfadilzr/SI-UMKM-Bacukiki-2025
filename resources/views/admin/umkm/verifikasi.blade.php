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
    font-size: 13px;
    font-weight: 500;
    color: var(--color-black);
    margin-bottom: 6px;
  }

  .form-control-readonly {
    background-color: #F3F4F6;
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
    border: 1px solid #9CA3AF;
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

<form action="{{ route('umkm.updateVerifikasi', $umkm->id) }}" method="POST" id="form-verifikasi">
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
      <p class="info-text mb-4">Silakan cek kesesuaian data UMKM di bawah. Apabila ada data yang tidak sesuai, harap lakukan perbaikan data pada menu Edit Data UMKM.</p>
      <div class="row g-4 mb-4">
        <div class="col-lg-4">
          <div class="foto-preview-container">
            <div class="foto-overlay">Pratinjau Foto UMKM</div>
            <img src="{{ $umkm->foto }}" alt="Foto UMKM {{ $umkm->nama }}" onerror="this.src='https://via.placeholder.com/800x600?text=Foto+Tidak+Ditemukan'">
          </div>
        </div>
        <div class="col-lg-8">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label-custom">Nama UMKM</label>
              <input type="text" class="form-control-readonly" value="{{ $umkm->nama }}" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label-custom">Kontak UMKM</label>
              <input type="text" class="form-control-readonly" value="{{ $umkm->kontak }}" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label-custom">Kategori UMKM</label>
              <input type="text" class="form-control-readonly" value="{{ $umkm->kategori ? $umkm->kategori->kategori_umkm : '-' }}" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label-custom">Kelurahan UMKM</label>
              <input type="text" class="form-control-readonly" value="{{ $umkm->kelurahan ? $umkm->kelurahan->nama_kelurahan : '-' }}" readonly>
            </div>
            <div class="col-12">
              <label class="form-label-custom">Alamat UMKM</label>
              <input type="text" class="form-control-readonly" value="{{ $umkm->alamat }}" readonly>
            </div>
            <div class="col-12">
              <label class="form-label-custom">Titik Lokasi UMKM</label>
              <input type="text" class="form-control-readonly" value="{{ $umkm->titik_maps }}" readonly>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('umkm.index') }}" class="btn btn-batal text-decoration-none">Batal</a>
        <button type="button" class="btn btn-selanjutnya" onclick="goToStep(2)">Selanjutnya</button>
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
        <label class="form-label-custom">Titik Lokasi UMKM</label><br>
        <a href="{{ $umkm->titik_maps }}" target="_blank" class="btn btn-maps mt-1">
          <iconify-icon icon="lucide:map-pin" style="font-size: 16px;"></iconify-icon> Buka di Google Maps
        </a>
      </div>
      <div class="row g-4 mb-4">
        <div class="col-md-6">
          <label class="form-label-custom">Latitude</label>
          <input type="text" name="latitude" class="form-control-custom" placeholder="Masukkan latitude (lintang)" value="{{ $umkm->latitude }}">
        </div>
        <div class="col-md-6">
          <label class="form-label-custom">Longitude</label>
          <input type="text" name="longitude" class="form-control-custom" placeholder="Masukkan longitude (bujur)" value="{{ $umkm->longitude }}">
        </div>
      </div>
      <div class="d-flex justify-content-end gap-2 mt-5">
        <button type="button" class="btn btn-batal" onclick="goToStep(1)">Sebelumnya</button>
        <button type="button" class="btn btn-selanjutnya" onclick="goToStep(3)">Selanjutnya</button>
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

      <div class="d-flex justify-content-end gap-2 mt-5">
        <button type="button" class="btn btn-batal" onclick="goToStep(2)">Sebelumnya</button>
        <button type="button" class="btn btn-selanjutnya" onclick="goToStep(4)">Selanjutnya</button>
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

  </div>
</form>

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
</script>
@endsection