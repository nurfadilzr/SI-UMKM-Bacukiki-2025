@extends('layouts.app')

@section('content')
<style>
  /* Styling Khusus Halaman Tabel (Disesuaikan ke skala 90%) */
  .page-title {
    font-weight: 700;
    /* Bold */
    font-size: 22px;
    /* Diperkecil dari 26px */
    color: var(--color-black);
    margin-bottom: 24px;
    /* Margin diperkecil dari 32px */
  }

  /* Container Card Tabel */
  .table-container {
    background: #FFFFFF;
    border: 1px solid var(--color-border);
    border-radius: 12px;
    padding: 20px;
    /* Padding diperkecil dari 24px */
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.02);
  }

  /* Styling Input Search & Select */
  .form-control,
  .form-select {
    border-radius: 6px;
    border: 1.5px solid var(--color-grey-500);
    font-size: 13px;
    color: var(--color-gray);
    font-weight: 400;
    padding: 8px 8px;
    box-shadow: none !important;
  }

  .form-control::placeholder {
    color: #9CA3AF;
  }

  /* Tombol Utama (Blue) */
  .btn-primary-custom {
    background-color: var(--color-blue);
    color: #FFFFFF;
    border-radius: 6px;
    padding: 8px 12px;
    /* Padding dirapatkan dari 10px 20px */
    font-weight: 500;
    font-size: 13px;
    /* Diperkecil dari 14px */
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: opacity 0.2s;
  }

  .btn-primary-custom:hover {
    opacity: 0.9;
    color: #FFFFFF;
  }

  /* Styling Tabel Dasar */
  .custom-table th {
    font-weight: 500;
    color: var(--color-gray);
    background-color: var(--color-gray-light);
    border-bottom: 1px solid var(--color-border);
    padding: 12px 14px;
    /* Padding dirapatkan dari 16px */
    font-size: 13px;
    /* Diperkecil dari 14px */
  }

  .custom-table td {
    padding: 12px 14px;
    /* Padding dirapatkan dari 16px */
    vertical-align: middle;
    font-size: 13px;
    /* Diperkecil dari 14px */
    color: var(--color-gray);
    font-weight: 400;
    border-bottom: 1px solid var(--color-border);
  }

  /* Styling Badge Status */
  .badge-custom {
    padding: 4px 10px;
    /* Padding dirapatkan dari 6px 12px */
    border-radius: 6px;
    font-weight: 500;
    font-size: 12px;
    /* Diperkecil dari 13px */
    display: inline-block;
  }

  /* Variasi Badge dari Color Tokens */
  .badge-disetujui {
    background-color: var(--color-green-light);
    color: var(--color-green);
  }

  .badge-menunggu {
    background-color: var(--color-orange-light);
    color: var(--color-orange);
  }

  .badge-ditolak {
    background-color: #E5E7EB;
    color: var(--color-gray);
  }

  .badge-aktif {
    background-color: var(--color-blue);
    color: #FFFFFF;
  }

  .badge-tidak-aktif {
    background-color: var(--color-gray);
    color: #FFFFFF;
  }

  /* Tombol Aksi */
  .btn-action {
    color: var(--color-gray);
    background: transparent;
    border: none;
    font-size: 16px;
    padding: 4px;
    border-radius: 4px;
  }

  .btn-action:hover {
    background-color: var(--color-gray-light);
    color: var(--color-black);
  }
</style>

<h2 class="page-title">Manajemen Verifikasi Data</h2>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 13px;">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 10px;"></button>
</div>
@endif

<div class="table-container">

  <form action="{{ route('umkm.index') }}" method="GET">
    <div class="row mb-3 align-items-center">

      <div class="col-md-4">
        <div class="input-group">
          <span class="input-group-text bg-white border-end-0" style="border: 1.5px solid var(--color-grey-500); border-top-left-radius: 8px; border-bottom-left-radius: 8px; color: var(--color-grey-500); padding: 8px 12px;">
            <iconify-icon icon="lucide:search" style="font-size: 16px;"></iconify-icon>
          </span>
          <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari UMKM" value="{{ request('search') }}">
        </div>
      </div>

      <div class="col-md-2"></div>

      <div class="col-md-3">
        <select name="status_verif" class="form-select" onchange="this.form.submit()">
          <option value="">Status Verifikasi</option>
          <option value="menunggu" {{ request('status_verif') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
          <option value="disetujui" {{ request('status_verif') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
          <option value="ditolak" {{ request('status_verif') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
      </div>

      <div class="col-md-3">
        <select name="status_umkm" class="form-select" onchange="this.form.submit()">
          <option value="">Status UMKM</option>
          <option value="aktif" {{ request('status_umkm') == 'aktif' ? 'selected' : '' }}>Aktif</option>
          <option value="tidak" {{ request('status_umkm') == 'tidak' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
      </div>
    </div>
  </form>

  <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('umkm.import.form') }}" class="btn-primary-custom text-decoration-none">
      <iconify-icon icon="lucide:plus" style="font-size: 16px;"></iconify-icon> Tambah UMKM
    </a>
  </div>

  <div class="table-responsive">
    <table class="table custom-table table-borderless mb-0">
      <thead>
        <tr>
          <th>Nama UMKM</th>
          <th>Alamat UMKM</th>
          <th>Kelurahan</th>
          <th>Kategori</th>
          <th>Status Verifikasi</th>
          <th>Status UMKM</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($umkms as $umkm)
        <tr>
          <td>{{ $umkm->nama }}</td>
          <td>{{ $umkm->alamat }}</td>
          <td>{{ $umkm->kelurahan ? $umkm->kelurahan->nama_kelurahan : '-' }}</td>
          <td>{{ $umkm->kategori ? $umkm->kategori->kategori_umkm : '-' }}</td>

          <td>
            @if($umkm->status_verif == 'disetujui')
            <span class="badge-custom badge-disetujui">Disetujui</span>
            @elseif($umkm->status_verif == 'menunggu')
            <span class="badge-custom badge-menunggu">Menunggu</span>
            @else
            <span class="badge-custom badge-ditolak">Ditolak</span>
            @endif
          </td>

          <td>
            @if($umkm->status_umkm == 'aktif')
            <span class="badge-custom badge-aktif">Aktif</span>
            @else
            <span class="badge-custom badge-tidak-aktif">Tidak Aktif</span>
            @endif
          </td>

          <td class="text-center">
            <div class="d-flex justify-content-center align-items-center gap-1">
              <form action="{{ route('umkm.destroy', $umkm->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="m-0 p-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-action" title="Hapus"><iconify-icon icon="lucide:trash-2"></iconify-icon></button>
              </form>

              <div class="dropdown m-0 p-0">
                <button class="btn-action" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <iconify-icon icon="lucide:more-vertical"></iconify-icon>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius: 8px; font-family: 'Lato', sans-serif; font-size: 13px;">
                  <li>
                    <a class="dropdown-item d-flex" href="{{ route('umkm.verifikasi', $umkm->id) }}"> Verifikasi Data </a>
                    <a class="dropdown-item d-flex" href="{{ route('umkm.verifikasi', $umkm->id) }}"> Edit Data </a>
                    <a class="dropdown-item d-flex" href="{{ route('umkm.verifikasi', $umkm->id) }}"> Ubah Status UMKM </a>
                  </li>
                </ul>
              </div>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center py-4" style="color: #9CA3AF;">Belum ada data UMKM.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-between align-items-center mt-3" style="font-size: 12px; color: #9CA3AF;">
    <div>
      Menampilkan {{ $umkms->firstItem() ?? 0 }} - {{ $umkms->lastItem() ?? 0 }} dari {{ $umkms->total() }} data
    </div>
    <div style="transform: scale(0.9); transform-origin: right center;">
      {{ $umkms->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
  </div>

</div>
@endsection