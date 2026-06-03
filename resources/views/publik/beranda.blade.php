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

    /* Hero Section */
    .hero-section {
      padding: 60px 0;
      background: #ECEFED;
    }

    .btn-custom {
      background-color: #41644A;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 500;
      text-decoration: none;
      display: inline-block;
    }

    .btn-custom:hover {
      background-color: #32553d;
      color: white;
    }

    /* Summary Card */
    .summary-card {
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      margin-top: -10px;
      position: relative;
      z-index: 10;
    }

    .teks-satu {
      font-size: 40px;
      font-weight: 700;
      color: #1B3B6F;
      margin-bottom: 0;
    }

    .teks-dua {
      font-size: 20px;
      font-weight: 600;
      color: #1B3B6F;
      margin-bottom: 0;
    }

    .teks-tiga {
      font-size: 14px;
      font-weight: 500;
      color: #1B3B6F;
      margin-bottom: 0;
    }

    /* Separator Responsif untuk Summary Card */
    .summary-divider {
      border-bottom: 1px solid #dee2e6;
      /* Garis horizontal pembatas di HP */
      margin-bottom: 25px;
      /* Jarak luar bawah di HP */
      padding-bottom: 25px;
      /* Jarak dalam bawah di HP */
    }

    /* Jika layar sebesar tablet/laptop (min 768px), ubah perilakunya */
    @media (min-width: 768px) {
      .summary-divider {
        border-bottom: none;
        /* Hilangkan garis horizontal */
        border-right: 1px solid #dee2e6;
        /* Ubah menjadi garis vertikal di kanan */
        margin-bottom: 0;
        /* Kembalikan jarak ke normal */
        padding-bottom: 0;
      }
    }

    /* Kartu UMKM Horizontal Scroll KHUSUS Mobile */
    @media (max-width: 767px) {
      .mobile-horizontal-scroll {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 15px;
        /* Memberi ruang untuk scrollbar */
        scroll-snap-type: x mandatory;
      }

      .mobile-horizontal-scroll>div {
        flex: 0 0 85%;
        /* Lebar kartu di HP 85% layar */
        scroll-snap-align: center;
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
      /* Batas maksimal lebar card (Bisa diubah: 280px, 300px, 320px) */
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
      color: #1F2937;
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
          <li class="nav-item"><a class="nav-link active d-inline-block" href="{{ route('beranda') }}">Beranda</a></li>
          <li class="nav-item"><a class="nav-link d-inline-block" href="{{ route('daftar') }}">Daftar UMKM</a></li>
          <li class="nav-item"><a class="nav-link d-inline-block" href="{{ route('peta') }}">Peta Sebaran</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="hero-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-start mb-5 mb-md-0">
          <p class="text-uppercase mb-1" style="font-size: 12px; font-weight: 600; color: #41644A;">Ayo Majukan UMKM Kita</p>
          <h1 class="font-weight-bold mb-3" style="color: #000; font-weight: 700;">Dukung Digitalisasi dan Pengembangan UMKM Lokal</h1>
          <p class="mb-4" style="max-width: 450px; color: #000; font-weight: 500; font-size: 14px;">Jelajahi data UMKM di setiap kelurahan, <br> lihat persebarannya, dan dukung pertumbuhan<br> ekonomi kreatif berbasis data.</p>
          <a href="{{ route('daftar') }}" class="btn-custom">Lihat Daftar UMKM</a>
        </div>
        <div class="col-md-6 text-center">
          <img src="{{ asset('images/hero_image.png') }}" alt="Ilustrasi UMKM" class="img-fluid" style="max-height: 320px;">
        </div>
      </div>
    </div>
  </section>

  <div class="container">
    <div class="summary-card">
      <div class="row text-center">
        <div class="col-md-4 summary-divider">
          <p class="teks-satu">{{ $totalUmkm }}</p>
          <p class="teks-dua">Total UMKM</p>
          <p class="teks-tiga">Terdapat banyak usaha yang telah terdaftar dan terverifikasi.</p>
        </div>
        <div class="col-md-4 summary-divider">
          <p class="teks-satu">{{ $totalKelurahan }}</p>
          <p class="teks-dua">Jumlah Kelurahan</p>
          <p class="teks-tiga">Galung Maloang, Lemoe, Lompoe, dan Watang Bacukiki.</p>
        </div>
        <div class="col-md-4">
          <p class="teks-satu">{{ $totalKategori }}</p>
          <p class="teks-dua">Jumlah Kategori</p>
          <p class="teks-tiga">Retail, Jasa, Makanan (Kuliner), dan Kerajinan Tangan.</p>
        </div>
      </div>
    </div>
  </div>

  <section class="container py-5 mt-4">
    <div class="text-center mb-4">
      <p class="text-uppercase mb-1" style="font-size: 12px; font-weight: 600; color: #41644A;">DAFTAR UMKM</p>
      <h4 style="color: #000; font-weight: 700;">Berbagai Kategori Dari Setiap Kelurahan, UMKM Bacukiki Semakin Terdepan</h4>
    </div>

    <div class="row g-1 mb-4 mobile-horizontal-scroll">
      @foreach($umkmTerbaru as $umkm)
      <div class="col-md-4">
        <div class="umkm-card h-100 d-flex flex-column" style="border: 1px solid #eee; border-radius: 12px; overflow: hidden; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.02); transition: 0.3s;">
          <img src="{{ $umkm->foto ? $umkm->foto : 'https://via.placeholder.com/400x300?text=Tidak+Ada+Foto' }}" style="height: 200px; width: 100%; object-fit: cover;" alt="Foto Usaha">
          <div class="p-3 d-flex flex-column flex-grow-1">
            <h5 class="umkm-title">{{ $umkm->nama }}</h5>
            <div class="d-flex gap-2 mb-4">
              <span class="badge-kategori">{{ $umkm->kategori->kategori_umkm ?? '-' }}</span>
              <span class="badge-kelurahan">{{ $umkm->kelurahan->nama_kelurahan ?? '-' }}</span>
            </div>
            <div class="btn-group-custom">
              <a href="{{ $umkm->titik_maps ?? '#' }}" target="_blank" class="btn-card btn-maps">Maps</a>
              <a href="https://wa.me/{{ $umkm->kontak }}" target="_blank" class="btn-card btn-kontak">Kontak</a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="text-center mt-4">
      <a href="{{ route('daftar') }}" class="btn-more">Lihat Semua</a>
    </div>
  </section>

  <section class="bg-light-green py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-5 pe-md-5 text-center text-md-start mb-4 mb-md-0">
          <h4 style="font-size: 20px; font-weight: 600; color: #41644A; margin-bottom: 10px;">Jumlah UMKM tiap Kelurahan</h4>
          <p style="font-size: 14px; font-weight: 500; color: #000">Data berikut menunjukkan persebaran jumlah UMKM<br> di setiap kelurahan di Kecamatan Bacukiki sebagai<br> gambaran potensi ekonomi lokal.</p>
        </div>

        <div class="col-md-6 offset-md-1 px-4 px-md-0">
          <div class="row g-3 g-md-4">
            @foreach($kelurahans as $kelurahan)
            <div class="col-6">
              <div class="card p-3 p-md-4 h-100 mx-auto" style="border-radius: 12px; box-shadow: 0 8px 16px rgba(0,0,0,0.06); max-width: 220px; background-color: #F6E4D3; padding: 12px 16px; width: 100%;">
                <h1 class="mb-1 mb-md-2" style="font-size: 36px; font-weight: 600; margin-bottom: 0px; color: #D17A22;">{{ $kelurahan->umkm_count }}</h1>
                <div style="font-weight: 500; font-size: 18px; color: #D17A22;">{{ $kelurahan->nama_kelurahan }}</div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="container py-5 mt-4 mb-5">
    <div class="row align-items-start">

      <div class="col-lg-5 col-md-6 order-1 order-md-2 text-center text-md-end ps-lg-5 mb-4 mb-md-0">
        <p class="text-uppercase mb-1" style="font-size: 12px; font-weight: 700; color: #41644A;">PETA SEBARAN</p>
        <h4 class="font-weight-bold" style="color: #000; font-weight: 700; font-size: 28px;">Peta Sebaran UMKM</h4>
        <p class="text-muted ms-md-auto mx-auto mx-md-0" style="font-size: 16px; line-height: 1.6; max-width: 400px;">
          Marker berbeda warna menunjukkan lokasi UMKM berdasarkan kelurahan. Data yang ditampilkan telah melalui proses verifikasi oleh admin kecamatan.
        </p>
      </div>

      <div class="col-lg-7 col-md-6 order-2 order-md-1">
        <div class="bg-white p-2 rounded shadow-sm" style="border: 1px solid #eaeaea;">
          <div id="map-preview" class="rounded bg-light d-flex align-items-center justify-content-center" style="height: 400px; z-index: 1;">
          </div>

          <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-3 mb-2" style="font-size: 12px; color: #444;">
            <span class="font-weight-bold d-none d-sm-inline" style="color: #111;">Keterangan:</span>
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

    </div>
  </section>

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
      // 1. Inisialisasi Peta (Atur koordinat pusat ke area Bacukiki/Parepare)
      // Silakan sesuaikan angka [-4.0435, 119.6421] jika posisinya kurang pas di tengah
      var map = L.map('map-preview').setView([-4.0200, 119.6500], 13);

      // 2. Muat Tampilan Dasar Peta (OpenStreetMap)
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);

      // 3. Tangkap data dari PHP ke format JSON yang dimengerti JavaScript
      var umkmData = @json($umkmMaps);

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
      umkmData.forEach(umkm => {
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
      });
    })
  </script>

</body>

</html>