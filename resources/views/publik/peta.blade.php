<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar UMKM - SI Data UMKM Kecamatan Bacukiki</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

  <style>
    body {
      font-family: 'Lato', sans-serif;
      color: #404040;
      background-color: #ECEFED;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Navbar */
    .navbar {
      padding: 15px 10px;
      background-color: #ECEFED;
    }

    .nav-link {
      color: #41644A;
      font-weight: 500;
      margin-left: 40px;
      padding-right: 0 !important;
      padding-bottom: 1px;
    }

    .nav-link.active {
      color: #41644A !important;
      font-weight: 700;
      border-bottom: 3px solid #41644A;
    }

    @media (min-width: 992px) {
      .nav-link {
        margin-left: 30px;
        padding-left: 0 !important;
        padding-right: 0 !important;
      }
    }

    /* === STYLING UMKM CARD === */
    .umkm-card {
      background: #FFFFFF;
      border: none;
      box-shadow: 0px 8px 24px rgba(149, 157, 165, 0.2);
      border-radius: 16px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      height: 100%;
      width: 100%;
      max-width: 280px;
      margin: 0 auto;
    }

    .umkm-card:hover {
      transform: translateY(-4px);
      /* box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1); */
      box-shadow: 0px 14px 28px rgba(149, 157, 165, 0.3);
    }

    .img-wrapper {
      width: 100%;
      height: 200px;
      /* Tinggi mutlak untuk menyeragamkan semua gambar */
      overflow: hidden;
      background-color: #F3F4F6;
    }

    .img-wrapper img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      /* memotong gambar agar pas tanpa distorsi */
    }

    .card-body-custom {
      padding: 16px;
      display: flex;
      flex-direction: column;
      flex: 1;
      /* Mengisi sisa ruang agar tombol selalu di bawah */
    }

    .umkm-title {
      font-size: 18px;
      font-weight: 700;
      color: #000;
      margin-bottom: 12px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      /* jika nama terlalu panjang */
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
      /* Mendorong tombol ke paling bawah card */
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

    .btn-more {
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      background-color: #8C8C8C;
      border: none;
      padding: 12px 16px;
      color: #000;
      text-decoration: none;
    }

    /* Footer */
    footer {
      background-color: #404040;
      color: white;
      padding: 30px 0;
      font-size: 14px;
      margin-top: auto;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg sticky-top bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="{{ route('beranda') }}">
        <img src="{{ asset('images/logo_pemda.png') }}" alt="Logo" height="40" class="me-2">
        <div>
          <div style="font-weight: 600; font-size: 16px; line-height: 1;">SI Data UMKM</div>
          <div style="font-size: 12px; color: #000;">Kecamatan Bacukiki</div>
        </div>
      </a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end text-center text-lg-end mt-3 mt-lg-0" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link d-inline-block" href="{{ route('beranda') }}">Beranda</a></li>
          <li class="nav-item"><a class="nav-link d-inline-block" href="{{ route('daftar') }}">Daftar UMKM</a></li>
          <li class="nav-item"><a class="nav-link active d-inline-block" href="{{ route('peta') }}">Peta Sebaran</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <main class="flex-grow-1">
    <section class="container py-4 py-lg-5 my-3">
      <div class="d-lg-none text-center mb-4 px-2">
        <p class="text-uppercase mb-1" style="font-size: 12px; font-weight: 700; color: #41644A;">PETA SEBARAN</p>
        <h2 class="font-weight-bold mb-2" style="color: #000; font-weight: 700;">Peta Sebaran UMKM</h2>
        <p class="text-muted mx-auto" style="font-size: 14px; line-height: 1.6; max-width: 420px;">
          Marker berbeda warna menunjukkan lokasi UMKM berdasarkan kelurahan. Data yang ditampilkan telah melalui proses verifikasi oleh admin kecamatan.
        </p>
      </div>
      <div class="row align-items-start">
        <div class="col-lg-7 mb-4 mb-lg-0">
          <div class="bg-white p-2 p-md-3 shadow-sm" style="border-radius: 16px;">
            <div id="map-preview" style="height: 60vh; min-height: 400px; max-height: 550px; z-index: 1; border-radius: 12px;"></div>
            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 gap-md-3 mt-3 mb-2" style="font-size: 12px; color: #444;">
              <span class="font-weight-bold d-none d-sm-inline" style="color: #000;">Keterangan:</span>
              <div class="d-flex align-items-center">
                <iconify-icon icon="mdi:map-marker" style="color: #41644A; font-size: 18px;"></iconify-icon> <span class="d-none d-sm-inline">Galung Maloang</span><span class="d-inline d-sm-none">G. Maloang</span>
              </div>
              <div class="d-flex align-items-center">
                <iconify-icon icon="mdi:map-marker" style="color: #1B3B6F; font-size: 18px;"></iconify-icon> Lompoe
              </div>
              <div class="d-flex align-items-center">
                <iconify-icon icon="mdi:map-marker" style="color: #D17A22; font-size: 18px;"></iconify-icon> Lemoe
              </div>
              <div class="d-flex align-items-center">
                <iconify-icon icon="mdi:map-marker" style="color: #404040; font-size: 18px;"></iconify-icon> <span class="d-none d-sm-inline">Watang Bacukiki</span><span class="d-inline d-sm-none">W. Bacukiki</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5 ps-lg-5">
          <div class="d-none d-lg-block text-end mb-5">
            <p class="text-uppercase mb-1" style="font-size: 12px; font-weight: 700; color: #41644A;">PETA SEBARAN</p>
            <h2 class="font-weight-bold mb-2" style="color: #000; font-weight: 700;">Peta Sebaran UMKM</h2>
            <p class="text-muted ms-auto" style="font-size: 15px; line-height: 1.6; max-width: 420px;">
              Marker berbeda warna menunjukkan lokasi UMKM berdasarkan kelurahan. Data yang ditampilkan telah melalui proses verifikasi oleh admin kecamatan.
            </p>
          </div>
          <div class="bg-white p-4 shadow-sm text-center mx-auto ms-lg-auto" style="border-radius: 16px; max-width: 420px; width: 100%;">
            <h5 class="mb-3" style="color: #333; font-weight: 600;">Detail UMKM</h5>
            <hr style="border-color: #ddd;">
            <div id="detail-kosong" class="py-3">
              <p class="text-muted fst-italic mb-0" style="font-size: 14px;">
                Klik salah satu marker untuk melihat detail umkm
              </p>
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
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center text-md-start">
      <img src="{{ asset('images/logo_pemda.png') }}" alt="Logo" height="50" class="me-md-3 mb-3 mb-md-0">
      <div>
        <h3 class="mb-1" style="font-size: 18px; font-weight: 700;">Kecamatan Bacukiki</h3>
        <p class="mb-0" style="font-size: 12px; font-weight: 500;">Jl. Jend. M. Yusuf Kelurahan Galung Maloang, Kecamatan Bacukiki, Kota Parepare, Provinsi Sulawesi Selatan</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

          map.flyTo([lat, lng], 15, {
            duration: 0.5
          });

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

          // Jika dibuka di HP, otomatis auto-scroll layar ke bagian kotak detail setelah diklik
          if (window.innerWidth < 992) {
            setTimeout(() => {
              detailContent.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
              });
            }, 500);
          }
        });
      })

      map.on('click', function() {
        resetMarkerSizes(); // Kecilkan semua marker

        // Sembunyikan detail, munculkan kembali teks default
        document.getElementById('detail-isi').style.display = 'none';
        document.getElementById('detail-kosong').style.display = 'block';
      });;
    });
  </script>
</body>

</html>