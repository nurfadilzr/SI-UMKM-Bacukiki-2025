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
      color: #333;
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
          <li class="nav-item"><a class="nav-link active d-inline-block" href="{{ route('daftar') }}">Daftar UMKM</a></li>
          <li class="nav-item"><a class="nav-link d-inline-block" href="{{ route('peta') }}">Peta Sebaran</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="container py-4 mt-3 text-center">
    <p class="text-uppercase mb-1" style="font-size: 12px; font-weight: 600; color: #41644A;">DAFTAR UMKM</p>
    <h2 class="font-weight-bold mx-auto mb-4" style="color: #111; max-width: 600px; line-height: 1.3; font-weight: 600;">
      Berbagai Kategori Dari Setiap Kelurahan, UMKM Bacukiki Semakin Terdepan
    </h2>
  </section>

  <section class="container mb-5 pb-5 px-4 px-md-2">
    <div class="row g-5">

      @foreach($umkms as $umkm)
      <div class="col-12 col-md-6 col-lg-3">
        <div class="h-100 d-flex flex-column" style="border: 1px solid #eee; border-radius: 16px; overflow: hidden; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">

          <div style="aspect-ratio: 4/3; width: 100%; overflow: hidden;">
            <img src="{{ $umkm->foto ? $umkm->foto : 'https://via.placeholder.com/400x300?text=Tidak+Ada+Foto' }}" style="width: 100%; height: 100%; object-fit: cover;" alt="Foto Usaha">
          </div>

          <div class="p-3 d-flex flex-column flex-grow-1">
            <h5 class="umkm-title">{{ $umkm->nama }}</h5>

            <div class="d-flex flex-wrap gap-2 mb-4">
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

    <div class="d-flex justify-content-center mt-5">
      {{ $umkms->links('pagination::bootstrap-5') }}
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
</body>

</html>