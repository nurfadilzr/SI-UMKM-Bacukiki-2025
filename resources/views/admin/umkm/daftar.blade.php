@extends('layouts.app')

@section('content')
<style>
  /* === STYLING HEADER & FILTER === */
  .page-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--color-black);
    margin-bottom: 24px;
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
    color: #4B5563;
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
    border-color: var(--color-green);
    outline: none;
  }

  /* === STYLING UMKM CARD === */
  .umkm-card {
    background: #FFFFFF;
    border: 1px solid #E5E7EB;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%;
    /* Agar tinggi card sama dalam satu baris */
  }

  .umkm-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1);
  }

  .img-wrapper {
    width: 100%;
    height: 180px;
    /* Tinggi mutlak untuk menyeragamkan semua gambar */
    overflow: hidden;
    background-color: #F3F4F6;
  }

  .img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    /* Ini kuncinya: memotong gambar agar pas tanpa distorsi */
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
    /* ... jika nama terlalu panjang */
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
    /* Warna Navy Maps */
    color: #FFFFFF;
  }

  .btn-kontak {
    background-color: var(--color-green);
    /* Warna Hijau Gelap Kontak */
    color: #FFFFFF;
  }
</style>

<div>
  <h2 class="page-title">Daftar UMKM</h2>

  <form action="{{ route('umkm.daftar') }}" method="GET" id="form-filter">
    <div class="filter-container">
      <div class="search-wrapper">
        <iconify-icon icon="lucide:search" class="search-icon"></iconify-icon>
        <input type="text" name="search" class="search-input-custom" placeholder="Cari UMKM..." value="{{ request('search') }}">
      </div>

      <div class="dropdown-group">
        <select name="kategori" class="filter-select-custom" onchange="this.form.submit()">
          <option value="">Semua Kategori</option>
          @foreach($kategoris as $kat)
          <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>{{ $kat->kategori_umkm }}</option>
          @endforeach
        </select>

        <select name="kelurahan" class="filter-select-custom" onchange="this.form.submit()">
          <option value="">Semua Kelurahan</option>
          @foreach($kelurahans as $kel)
          <option value="{{ $kel->id }}" {{ request('kelurahan') == $kel->id ? 'selected' : '' }}>{{ $kel->nama_kelurahan }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </form>

  <div class="row g-4">
    @forelse($umkms as $umkm)
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
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
            <a href="{{ $umkm->titik_maps ?? '#' }}" target="_blank" class="btn-card btn-maps">
              Maps
            </a>

            @php
            // Logika Pembersihan & Format Nomor WhatsApp
            $nomor_hp = preg_replace('/[^0-9]/', '', $umkm->kontak);
            if (str_starts_with($nomor_hp, '0')) {
            $nomor_hp = '62' . substr($nomor_hp, 1);
            }
            $link_wa = "https://wa.me/" . $nomor_hp;
            @endphp

            <a href="{{ $link_wa }}" target="_blank" class="btn-card btn-kontak">
              Kontak
            </a>
          </div>
        </div>
      </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
      <iconify-icon icon="lucide:box" style="font-size: 48px; color: #9CA3AF; margin-bottom: 16px;"></iconify-icon>
      <h5 style="color: #4B5563;">Tidak ada UMKM yang ditemukan.</h5>
      <p style="color: #9CA3AF; font-size: 14px;">Coba ubah kata kunci pencarian atau filter Anda.</p>
    </div>
    @endforelse
  </div>

  <div class="mt-4">
    {{ $umkms->links('pagination::bootstrap-5') }}
  </div>

</div>
@endsection