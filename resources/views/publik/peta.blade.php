<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Beranda - SI Data UMKM Kecamatan Bacukiki</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

  <style>
    body {
      font-family: 'Lato', sans-serif;
      color: #333;
      background-color: #ECEFED;
    }

    /* Navbar */
    .navbar {
      padding: 15px 50px;
      background-color: #ECEFED;
    }

    .nav-link {
      color: #41644A;
      font-weight: 500;
      margin-left: 40px;
      /* Mengatur jarak antar menu */
      padding-left: 0 !important;
      /* Memaksa batas kiri pas dengan huruf */
      padding-right: 0 !important;
      /* Memaksa batas kanan pas dengan huruf */
      padding-bottom: 1px;
      /* Mengatur jarak vertikal antara teks dan garis */
    }

    .nav-link.active {
      color: #41644A !important;
      font-weight: 700;
      border-bottom: 3px solid #41644A;

    }

    .page-title {
      font-weight: 700;
      font-size: 22px;
      color: #000;
      margin-bottom: 24px;
    }

    .badge-group {
      display: flex;
      gap: 8px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }

    .badge-kategori {
      background-color: #F1D7BD;
      color: #D17A22;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 500;
    }

    .badge-kelurahan {
      background-color: #C6C6C6;
      color: #404040;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 500;
    }

    .btn-group-custom {
      display: flex;
      gap: 8px;
      margin-top: auto;
    }

    .btn-card {
      flex: 1;
      border: none;
      border-radius: 8px;
      padding: 8px 0;
      font-size: 13px;
      font-weight: 500;
      text-align: center;
      text-decoration: none;
      transition: opacity 0.2s;
    }

    .btn-card:hover {
      opacity: 0.85;
      color: white;
    }

    .btn-maps {
      background-color: #1B3B6F;
      color: #FFFFFF;
    }

    .btn-kontak {
      background-color: #41644A;
      color: #FFFFFF;
    }

    /* Footer */
    footer {
      background-color: #404040;
      color: white;
      padding: 30px 0;
      font-size: 14px;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{ asset('images/logo_pemda.png') }}" alt="Logo" height="40" class="me-2">
      <div>
        <div style="font-weight: 600; font-size: 16px; line-height: 1;">SI Data UMKM</div>
        <div style="font-size: 12px; color: #000;">Kecamatan Bacukiki</div>
      </div>
    </a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('daftar') }}">Daftar UMKM</a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ route('peta') }}">Peta Sebaran</a></li>
      </ul>
    </div>
  </nav>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

  <main class="flex-grow-1">
    <section class="container py-4 my-3">
      <div class="row align-items-start">
        <div class="col-lg-7 mb-5 mb-lg-0">
          <div class="bg-white p-3 shadow-sm" style="border-radius: 16px;">
            <div id="map-preview" style="height: 550px; z-index: 1; border-radius: 12px;"></div>
            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2" style="font-size: 12px; color: #444;">
              <span class="font-weight-bold" style="color: #111;">Keterangan:</span>
              <div class="d-flex align-items-center">
                <iconify-icon icon="mdi:map-marker" style="color: #41644A; font-size: 18px;"></iconify-icon> UMKM Galung Maloang
              </div>
              <div class="d-flex align-items-center">
                <iconify-icon icon="mdi:map-marker" style="color: #1B3B6F; font-size: 18px;"></iconify-icon> UMKM Lompoe
              </div>
              <div class="d-flex align-items-center">
                <iconify-icon icon="mdi:map-marker" style="color: #D17A22; font-size: 18px;"></iconify-icon> UMKM Lemoe
              </div>
              <div class="d-flex align-items-center">
                <iconify-icon icon="mdi:map-marker" style="color: #404040; font-size: 18px;"></iconify-icon> UMKM Watang Bacukiki
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-5 text-end ps-lg-4">
          <p class="text-uppercase mb-1" style="font-size: 12px; font-weight: 700; color: #41644A;">PETA SEBARAN</p>
          <h2 class="font-weight-bold mb-1" style="color: #000; font-weight: 700;">Peta Sebaran UMKM</h2>
          <p class="text-muted ms-auto mb-5" style="font-size: 15px; line-height: 1.6; max-width: 420px;">
            Marker berbeda warna menunjukkan lokasi UMKM berdasarkan kelurahan. Data yang ditampilkan telah melalui proses verifikasi oleh admin kecamatan.
          </p>

          <div class="bg-white p-3 shadow-sm text-center ms-auto" style="border-radius: 16px; max-width: 420px;">
            <h5 class="mb-3" style="color: #000; font-weight: 500;">Detail UMKM</h5>
            <hr style="border-color: #ddd;">
            <div id="detail-kosong" class="text-center mt-4 mb-4 text-muted" style="font-style: italic; font-size: 14px;">
              Klik salah satu marker untuk melihat detail umkm
            </div>
            <div id="detail-isi" style="display: none; flex-direction: column;" class="text-start fade-in px-2 pb-2">
              <h4 id="dtl-nama" style="font-weight: 700; font-size: 22px; color: #000; margin-bottom: 14px;">Nama UMKM</h4>
              <div class="d-flex gap-2 justify-content-start mb-3" style="display: flex; gap: 8px;">
                <span id="dtl-kategori" class="badge-kategori">Kategori</span>
                <span id="dtl-kelurahan" class="badge-kelurahan">Kelurahan</span>
              </div>
              <p class="text-dark mb-3 d-flex align-items-start gap-2" style="font-size: 15px;">
                <iconify-icon icon="fa6-solid:location-dot" style="font-size: 18px; margin-top: 3px; color: #000;"></iconify-icon>
                <span id="dtl-alamat">Alamat UMKM</span>
              </p>
              <div class="btn-group-custom">
                <a href="#" id="dtl-btn-maps" target="_blank" class="btn-card btn-maps">Maps</a>
                <a href="#" id="dtl-btn-kontak" target="_blank" class="btn-card btn-kontak">Kontak</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <div class="container d-flex align-items-center justify-content-center">
      <img src="{{ asset('images/logo_pemda.png') }}" alt="Logo" height="50" class="me-3">
      <div>
        <h3 class="mb-1" style="font-size: 18px; font-weight: 700;">Kecamatan Bacukiki</h3>
        <p class="mb-0" style="font-size: 12px; font-weight: 500;">Jl. Jend. M. Yusuf Kelurahan Galung Maloang, Kecamatan Bacukiki, Kota Parepare, Provinsi Sulawesi Selatan</p>
      </div>
    </div>
  </footer>
</body>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // 1. Terima data JSON dari Laravel
    const dataUmkm = @json($umkmMaps);

    // 2. Inisialisasi Peta (Koordinat tengah Kecamatan Bacukiki)
    const map = L.map('map-preview').setView([-4.0200, 119.6500], 13);

    // 3. Pasang Tile Layer (Peta Dasarnya dari OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Variabel untuk menyimpan marker yang sedang dipilih
    let selectedMarker = null;
    // Variabel untuk menyimpan semua marker
    let allMarkers = [];

    // 4. Fungsi Pembuat Marker Dinamis dengan Parameter Ukuran (kecil / besar)
    function getMarkerIcon(namaKelurahan, size = 'small') {
      let pinColor = "#404040"; // Default Hitam (Watang Bacukiki)

      // Sesuaikan nama string ini dengan nama asli kelurahan di database Anda!
      if (namaKelurahan.includes('Galung Maloang')) pinColor = "#41644A"; // Hijau
      else if (namaKelurahan.includes('Lompoe')) pinColor = "#1B3B6F"; // Biru Gelap
      else if (namaKelurahan.includes('Lemoe')) pinColor = "#D17A22"; // Oranye

      // Tentukan ukuran SVG dan Anchor berdasarkan parameter size
      let svgWidth, svgHeight, iconWidth, iconHeight, anchorX, anchorY;

      if (size === 'small') {
        svgWidth = 20;
        svgHeight = 28;
        iconWidth = 20;
        iconHeight = 28;
        anchorX = 11;
        anchorY = 31;
      } else { // 'large'
        svgWidth = 30;
        svgHeight = 42;
        iconWidth = 30;
        iconHeight = 42;
        anchorX = 15;
        anchorY = 42;
      }

      const svgIcon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="${svgWidth}" height="${svgHeight}"><path fill="${pinColor}" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>`;

      return L.divIcon({
        html: svgIcon,
        className: '',
        iconSize: [iconWidth, iconHeight],
        iconAnchor: [anchorX, anchorY] // Titik tumpu pin agar pas di koordinat
      });
    }

    // Fungsi untuk mereset ukuran semua marker menjadi kecil
    function resetMarkerSizes() {
      allMarkers.forEach(item => {
        const smallIcon = getMarkerIcon(item.kelurahan, 'small');
        item.marker.setIcon(smallIcon);
      });
    }

    // 5. Looping Data UMKM untuk Ditaruh di Peta
    dataUmkm.forEach(umkm => {
      const lat = parseFloat(umkm.latitude);
      const lng = parseFloat(umkm.longitude);
      const namaKelurahan = umkm.kelurahan ? umkm.kelurahan.nama_kelurahan : '';

      // Lewati jika koordinat tidak valid (NaN)
      if (isNaN(lat) || isNaN(lng)) return;

      // Buat Marker (Secara default berukuran KECIL)
      const marker = L.marker([lat, lng], {
        icon: getMarkerIcon(namaKelurahan, 'small')
      }).addTo(map);

      // Simpan marker dan kelurahan ke dalam array
      allMarkers.push({
        marker: marker,
        kelurahan: namaKelurahan
      });

      // 6. EVENT LISTENER: Apa yang terjadi saat Marker diklik?
      marker.on('click', function() {

        // --- Logika Resizing Marker ---
        // 1. Reset semua marker lain menjadi kecil
        resetMarkerSizes();
        // 2. Ubah marker yang diklik menjadi BESAR
        const largeIcon = getMarkerIcon(namaKelurahan, 'large');
        marker.setIcon(largeIcon);
        // Simpan marker yang sedang dipilih
        selectedMarker = marker;

        // --- Sisa kode untuk menampilkan detail di sidebar (TETAP SAMA) ---

        // Sembunyikan teks default, Munculkan isi detail
        document.getElementById('detail-kosong').style.display = 'none';
        document.getElementById('detail-isi').style.display = 'flex';

        // Ganti isi teks HTML
        document.getElementById('dtl-nama').innerText = umkm.nama;
        document.getElementById('dtl-alamat').innerText = umkm.alamat;

        // Ganti Badge
        document.getElementById('dtl-kategori').innerText = umkm.kategori ? umkm.kategori.kategori_umkm : '-';
        document.getElementById('dtl-kelurahan').innerText = namaKelurahan || '-';

        // Ganti Link Tombol
        document.getElementById('dtl-btn-maps').href = umkm.titik_maps || `https://www.google.com/maps/search/?api=1&query=${lat},${lng}`;
        document.getElementById('dtl-btn-kontak').href = umkm.kontak ? `https://wa.me/${umkm.kontak}` : '#';
      });
    });
  });
</script>

</html>