@extends('layouts.app')

@section('content')
<style>
  /* === STYLING HEADER & FILTER === */
  .page-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--color-black);
    margin-bottom: 24px;
    /* padding: 8px 12px; */
  }

  .filter-container {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
  }

  .search-wrapper {
    position: relative;
    flex: 1;
    min-width: 250px;
    max-width: 350px;
  }

  .search-wrapper .search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #9CA3AF;
    font-size: 18px;
  }

  .search-input-custom {
    border: 1px solid #E5E7EB;
    border-radius: 8px;
    padding: 10px 16px 10px 40px;
    font-size: 14px;
    width: 100%;
    background-color: #FFFFFF;
    transition: border-color 0.2s ease;
  }

  .search-input-custom:focus {
    border-color: var(--color-green);
    outline: none;
    box-shadow: 0 0 0 3px rgba(65, 109, 80, 0.1);
    /* Menggunakan tone hijau sistem */
  }

  .dropdown-group {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
  }

  .filter-select-custom {
    border: 1px solid #E5E7EB;
    border-radius: 8px;
    padding: 10px 36px 10px 16px;
    font-size: 14px;
    color: var(--color-gray);
    background-color: #FFFFFF;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%239CA3AF' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 12px 10px;
    min-width: 160px;
  }

  .filter-select-custom:focus {
    background-color: #FFFFFF;
    border-color: var(--color-green) !important;
    box-shadow: 0 0 0 3px rgba(65, 100, 74, 0.15) !important;
  }

  /* === STYLING UMKM CARD === */
  .umkm-grid-container {
    /* display: grid;
    grid-template-columns: repeat(auto-fill, minmax(min(100%, 260px), 260px));
    gap: 24px; */
    /* Jarak antar kartu statis tidak berubah */
    justify-content: start;
    display: flex;
    flex-wrap: wrap;
    /* Izinkan kartu turun ke bawah JIKA tidak muat */
    gap: 20px;

    /* RUMUS MAKSIMAL 4 KARTU: 
       (260px * 4 kartu) + (24px * 3 jarak) = 1112px 
       Ini mencegah masuknya kartu ke-5 jika layar ditarik sangat lebar */
    max-width: 1112px;
  }

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
    flex: 0 0 260px;
    width: 260px;
    height: 100%;
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
    background-color: var(--color-orange-200);
    color: var(--color-orange);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
  }

  .badge-kelurahan {
    background-color: var(--color-gray-200);
    color: var(--color-gray);
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
    background-color: var(--color-blue);
    color: #FFFFFF;
  }

  .btn-kontak {
    background-color: var(--color-green);
    color: #FFFFFF;
  }

  /* CSS pagination */
  .pagination .page-link {
    color: var(--color-green) !important;
    border-color: #E5E7EB;
  }

  /* 2. Mengubah warna background saat kotak angka sedang aktif (diklik) */
  .pagination .page-item.active .page-link {
    background-color: var(--color-green) !important;
    border-color: var(--color-green) !important;
    color: #FFFFFF !important;
  }

  /* 3. Efek saat mouse diarahkan (hover) ke kotak angka */
  .pagination .page-link:hover {
    background-color: var(--color-green-light, #F0FDF4) !important;
    color: var(--color-green) !important;
    border-color: #E5E7EB;
  }

  /* 4. Menghilangkan bayangan (glow) biru saat diklik, ganti jadi hijau */
  .pagination .page-link:focus {
    box-shadow: 0 0 0 0.2rem rgba(65, 100, 74, 0.25) !important;
  }

  /* 5. Warna untuk tombol yang mati (disabled) seperti panah kiri di halaman pertama */
  .pagination .page-item.disabled .page-link {
    color: #9CA3AF !important;
    background-color: #F9FAFB !important;
    border-color: #E5E7EB;
  }

  /* =========================================
     === CSS RESPONSIVE KHUSUS MOBILE ===
     ========================================= */
  @media (max-width: 768px) {
    .page-title {
      font-size: 20px;
      margin-bottom: 16px;
    }

    /* 1. Ubah container agar membungkus ke bawah (wrap) dan posisinya di tengah */
    .filter-container {
      flex-wrap: wrap;
      justify-content: center;
      gap: 12px;
      margin-bottom: 24px;
      /* Mematikan scroll horizontal */
      padding-bottom: 0;
    }

    /* 2. Search bar mengambil lebar penuh (100%) di baris pertama */
    .search-wrapper {
      flex: 1 1 100%;
      min-width: 100%;
      max-width: 100%;
    }

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
    .filter-select-custom {
      flex: 1;
      /* Perintah agar lebarnya seimbang */
      min-width: 0;
      /* Mencegah elemen keluar batas layar jika terlalu kecil */
      font-size: 13px;
      padding: 8px 28px 8px 12px;
      background-position: right 8px center;
    }

    .umkm-grid-container {
      justify-content: center;
    }

    /* Kartu UMKM memanjang penuh di layar HP */
    .umkm-card {
      max-width: 260px;
      margin: 0 auto;
      flex: 0 0 100%;
      /* Kartu bisa menyesuaikan jika layar HP sangat sempit */
    }

    /* Menurunkan tinggi gambar sedikit agar proporsional di HP */
    .img-wrapper {
      height: 180px;
    }
  }
</style>

<div class="container-fluid mb-5 p-3 p-md-4 ">
  <h2 class="page-title">Daftar UMKM</h2>

  <form action="{{ route('umkm.daftar') }}" method="GET" id="form-filter">
    <div class="filter-container">
      <div class="search-wrapper">
        <iconify-icon icon="lucide:search" class="search-icon"></iconify-icon>
        <input type="text" name="search" class="search-input-custom" placeholder="Cari UMKM..." value="{{ request('search') }}">
      </div>
      <div class="dropdown-group">
        <div class="dropdown" style="flex: 1; min-width: 0;">
          <button class="btn filter-select-custom w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-image: none; padding-right: 12px;">
            <span id="label-kategori" class="text-truncate">Semua Kategori</span>
            <iconify-icon icon="lucide:chevron-down" style="color: #9CA3AF; min-width: 16px;"></iconify-icon>
          </button>
          <ul class="dropdown-menu w-100 shadow-sm" style="border-radius: 8px; font-size: 13px; border: 1px solid #E5E7EB; padding: 8px 0;">
            <li><a class="dropdown-item py-2" href="#" onclick="applyFilter('kategori', '', 'Semua Kategori')">Semua Kategori</a></li>
            @foreach($kategoris as $kat)
            <li><a class="dropdown-item py-2" href="#" onclick="applyFilter('kategori', '{{ $kat->id }}', '{{ $kat->kategori_umkm }}')">{{ $kat->kategori_umkm }}</a></li>
            @endforeach
          </ul>
          <input type="hidden" name="kategori" id="input-kategori" value="{{ request('kategori') }}">
        </div>
        <div class="dropdown" style="flex: 1; min-width: 0;">
          <button class="btn filter-select-custom w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-image: none; padding-right: 12px;">
            <span id="label-kelurahan" class="text-truncate">Semua Kelurahan</span>
            <iconify-icon icon="lucide:chevron-down" style="color: #9CA3AF; min-width: 16px;"></iconify-icon>
          </button>
          <ul class="dropdown-menu w-100 shadow-sm" style="border-radius: 8px; font-size: 13px; border: 1px solid #E5E7EB; padding: 8px 0;">
            <li><a class="dropdown-item py-2" href="#" onclick="applyFilter('kelurahan', '', 'Semua Kelurahan')">Semua Kelurahan</a></li>
            @foreach($kelurahans as $kel)
            <li><a class="dropdown-item py-2" href="#" onclick="applyFilter('kelurahan', '{{ $kel->id }}', '{{ $kel->nama_kelurahan }}')">{{ $kel->nama_kelurahan }}</a></li>
            @endforeach
          </ul>
          <input type="hidden" name="kelurahan" id="input-kelurahan" value="{{ request('kelurahan') }}">
        </div>
      </div>
    </div>
  </form>

  <div class="umkm-grid-container mt-2">
    @forelse($umkms as $umkm)
    <div class="umkm-card">
      <div class="img-wrapper">
        <img src="{{ $umkm->foto ? $umkm->foto : 'https://via.placeholder.com/400x300?text=Tidak+Ada+Foto' }}" alt="Foto {{ $umkm->nama }}">
      </div>
      <div class="card-body-custom">
        <h4 class="umkm-title" title="{{ $umkm->nama }}">{{ $umkm->nama }}</h4>
        <div class="badge-group">
          <span class="badge-kategori">{{ $umkm->kategori->kategori_umkm ?? 'Tanpa Kategori' }}</span>
          <span class="badge-kelurahan">{{ $umkm->kelurahan->nama_kelurahan ?? 'Tanpa Kelurahan' }}</span>
        </div>
        <div class="btn-group-custom">
          <a href="{{ $umkm->titik_maps ?? '#' }}" target="_blank" class="btn-card btn-maps">Maps</a>
          <a href="https://wa.me/{{ $umkm->kontak }}" target="_blank" class="btn-card btn-kontak">Kontak</a>
        </div>
      </div>
    </div>
    @empty
    <div class="d-flex flex-column justify-content-center align-items-center text-center w-100" style="min-height: 50vh;">
      <iconify-icon icon="lucide:box" style="font-size: 48px; color: #9CA3AF; margin-bottom: 16px;"></iconify-icon>
      <h5 style="color: #4B5563; font-weight: 600;">Tidak ada UMKM yang ditemukan.</h5>
      <p style="color: #9CA3AF; font-size: 14px;">Coba ubah kata kunci pencarian atau filter Anda.</p>
    </div>
    @endforelse
  </div>

  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2" style="font-size: 12px; color: var(--color-gray-500);">
    <div>
      Menampilkan {{ $umkms->firstItem() ?? 0 }} - {{ $umkms->lastItem() ?? 0 }} dari {{ $umkms->total() }} data
    </div>
    <div style="transform: scale(0.9); transform-origin: center right;">
      {{ $umkms->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
  </div>

</div>

<script>
  // Fungsi untuk menangani klik pada custom dropdown
  function applyFilter(type, value, label) {
    // 1. Ubah nilai pada input tersembunyi
    document.getElementById('input-' + type).value = value;

    // 2. Kirim form secara otomatis
    document.getElementById('form-filter').submit();
  }

  // --- Opsional: Skrip untuk mengingat teks label setelah halaman direfresh ---
  document.addEventListener('DOMContentLoaded', function() {
    // Ambil nilai filter saat ini dari URL/Input
    let currentKategori = document.getElementById('input-kategori').value;
    let currentKelurahan = document.getElementById('input-kelurahan').value;

    // Jika ada nilai, cari labelnya di dalam daftar dan ubah teks tombolnya
    if (currentKategori) {
      let activeItem = document.querySelector(`a[onclick*="applyFilter('kategori', '${currentKategori}'"]`);
      if (activeItem) document.getElementById('label-kategori').innerText = activeItem.innerText;
    }

    if (currentKelurahan) {
      let activeItem = document.querySelector(`a[onclick*="applyFilter('kelurahan', '${currentKelurahan}'"]`);
      if (activeItem) document.getElementById('label-kelurahan').innerText = activeItem.innerText;
    }
  });
</script>

@endsection