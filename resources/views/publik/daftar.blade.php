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
        <li class="nav-item"><a class="nav-link active" href="{{ route('daftar') }}">Daftar UMKM</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('peta') }}">Peta Sebaran</a></li>
      </ul>
    </div>
  </nav>

  <section class="container py-4 mt-4">
    <div class="text-center mb-5">
      <p class="text-uppercase mb-1" style="font-size: 12px; font-weight: 600; color: #41644A;">DAFTAR UMKM</p>
      <h4 class="font-weight-bold mb-3" style="color: #000; font-weight: 700;">Berbagai Kategori Dari Setiap Kelurahan,<br>UMKM Bacukiki Semakin Terdepan</h4>
    </div>

    <div class="row g-4 mb-4">
      @foreach($umkms as $umkm)
      <div class="col-lg-3 col-md-4 col-sm-6">
        <!-- Hapus p-3 dari sini, tambahkan h-100 dan d-flex flex-column agar tinggi seragam -->
        <div class="umkm-card w-100 d-flex flex-column" style="border: 1px solid #eee; border-radius: 12px; overflow: hidden; background: white; transition: 0.3s;">

          <!-- Gambar sekarang nempel ke ujung atas tanpa padding -->
          <img src="{{ $umkm->foto ? $umkm->foto : 'https://via.placeholder.com/400x300?text=Tidak+Ada+Foto' }}" style="height: 200px; width: 100%; object-fit: cover;" alt="Foto Usaha">

          <!-- Konten Teks & Tombol dibungkus di dalam div ini dengan padding (p-4) -->
          <div class="p-3 d-flex flex-column flex-grow-1">

            <h5 class="umkm-title">{{ $umkm->nama }}</h5>

            <!-- Badges (Kategori & Kelurahan) dengan padding px-3 py-1 agar lebih lonjong -->
            <div class="d-flex gap-2 mb-4">
              <span class="badge-kategori">{{ $umkm->kategori->kategori_umkm ?? '-' }}</span>
              <!-- Ubah warna background badge kelurahan agar mirip desain admin -->
              <span class="badge-kelurahan">{{ $umkm->kelurahan->nama_kelurahan ?? '-' }}</span>
            </div>

            <!-- Tombol dibungkus d-flex dan diberi mt-auto agar selalu terdorong ke bawah -->
            <div class="btn-group-custom">
              <a href="{{ $umkm->titik_maps ?? '#' }}" target="_blank" class="btn-card btn-maps">Maps</a>
              <a href="https://wa.me/{{ $umkm->kontak }}" target="_blank" class="btn-card btn-kontak">Kontak</a>
            </div>

          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>


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

</html>