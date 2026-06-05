@extends('layouts.app')

<!-- HALAMAN MANAJEMEN VERIF DATA -->

@section('content')
<style>
  .page-title {
    font-weight: 700;
    font-size: 22px;
    color: var(--color-black);
    margin-bottom: 24px;
  }

  .table-container {
    background: #FFFFFF;
    border: 1px solid var(--color-border);
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.02);
  }

  /* Trik agar border ikon dan border input menyala bersamaan saat diklik */
  .custom-search-group:focus-within .search-icon-span,
  .custom-search-group:focus-within .search-input-custom {
    border-color: var(--color-green) !important;
  }

  .custom-search-group:focus-within {
    box-shadow: 0 0 0 3px rgba(65, 100, 74, 0.15);
    border-radius: 6px;
  }

  /* Ikon Kaca Pembesar di Kiri */
  .search-icon-span {
    border: 1.5px solid #E5E7EB;
    border-right: none !important;
    border-top-left-radius: 6px;
    border-bottom-left-radius: 6px;
    padding: 10px 14px;
    background-color: #FFFFFF;
    color: #9CA3AF;
    transition: border-color 0.2s ease;
  }

  /* Kolom Ketik Search */
  .search-input-custom {
    border: 1.5px solid #E5E7EB;
    border-left: none !important;
    border-top-right-radius: 6px;
    border-bottom-right-radius: 6px;
    font-size: 14px;
    box-shadow: none !important;
    transition: border-color 0.2s ease;
  }

  /* === STYLING UNTUK DROPDOWN === */
  .filter-select-custom {
    border: 1.5px solid #E5E7EB;
    border-radius: 6px;
    font-size: 14px;
    padding: 10px 14px;
    color: var(--color-gray);
    box-shadow: none !important;
    transition: all 0.2s ease;
  }

  .filter-select-custom:focus {
    border-color: var(--color-green) !important;
    box-shadow: 0 0 0 3px rgba(65, 100, 74, 0.15) !important;
  }

  /* Tombol Utama (Blue) */
  .btn-primary-custom {
    background-color: var(--color-blue);
    color: #FFFFFF;
    border-radius: 6px;
    padding: 8px 12px;
    font-weight: 500;
    font-size: 13px;
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

  /* === STYLING TOMBOL PILIHAN TAMBAH DATA (MODAL) === */
  .btn-choice {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 20px;
    border-radius: 10px;
    border: 1px solid var(--color-border);
    background-color: #FFFFFF;
    color: var(--color-black);
    text-decoration: none;
    transition: all 0.2s ease-in-out;
    text-align: left;
  }

  .btn-choice:hover {
    border-color: var(--color-green);
    background-color: var(--color-green-light);
  }

  .btn-choice .icon-box {
    background-color: var(--color-gray-light);
    padding: 12px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: var(--color-gray);
    transition: all 0.2s;
  }

  .btn-choice:hover .icon-box {
    background-color: #FFFFFF;
    color: var(--color-green);
  }

  .btn-choice .text-box {
    display: flex;
    flex-direction: column;
  }

  .btn-choice .title {
    font-size: 15px;
    font-weight: 700;
    color: var(--color-black);
    margin-bottom: 2px;
  }

  .btn-choice .subtitle {
    font-size: 12px;
    color: #9CA3AF;
  }

  /* Styling Tabel Dasar */
  .custom-table th {
    font-weight: 500;
    color: var(--color-gray);
    background-color: var(--color-gray-light);
    border-bottom: 1px solid var(--color-border);
    padding: 12px 14px;
    font-size: 13px;
  }

  .custom-table td {
    padding: 12px 14px;
    vertical-align: middle;
    font-size: 13px;
    color: var(--color-gray);
    font-weight: 400;
    border-bottom: 1px solid var(--color-border);
  }

  /* Styling Badge Status */
  .badge-custom {
    padding: 4px 10px;
    border-radius: 6px;
    font-weight: 500;
    font-size: 12px;
    display: inline-block;
  }

  .badge-disetujui {
    background-color: var(--color-green-300);
    color: var(--color-green);
  }

  .badge-menunggu {
    background-color: var(--color-orange-200);
    color: var(--color-orange);
  }

  .badge-ditolak {
    background-color: var(--color-gray-200);
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

  /* === STYLING MODAL HAPUS === */
  .modal-backdrop.show {
    opacity: 0.3 !important;
  }

  .btn-modal-batal {
    background-color: white;
    color: var(--color-gray);
    border: 1.5px solid var(--color-gray-500);
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.1s;
  }

  .btn-modal-batal:hover {
    background-color: var(--color-gray-50);
    border: 1.5px solid var(--color-gray-500);
  }

  .btn-modal-hapus {
    background-color: var(--color-orange);
    color: #FFFFFF;
    border: none;
    border-radius: 6px;
    padding: 8px 20px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
  }

  .btn-modal-hapus:hover {
    opacity: 0.9;
    color: white;
  }

  /* =========================================
     === CSS KHUSUS MOBILE (ACCORDION VIEW) ===
     ========================================= */
  @media (max-width: 768px) {
    .page-title {
      font-size: 20px;
      margin-bottom: 16px;
    }

    .table-container {
      padding: 16px;
    }

    /* Layout Form Pencarian Mobile */
    .filter-select-custom {
      font-size: 12px;
      /* Dikecilkan sedikit di HP agar tidak memakan tempat */
      padding: 8px 10px;
      background-position: right 8px center;
    }

    /* Accordion Card Styles */
    .mobile-card {
      border: 1px solid #E5E7EB;
      border-bottom: none;
      background: #FFFFFF;
    }

    /* Membulatkan sudut atas list pertama dan sudut bawah list terakhir */
    .mobile-card:first-child {
      border-top-left-radius: 8px;
      border-top-right-radius: 8px;
    }

    .mobile-card:last-child {
      border-bottom: 1px solid #E5E7EB;
      border-bottom-left-radius: 8px;
      border-bottom-right-radius: 8px;
    }

    .mobile-card-header {
      padding: 16px;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }

    .mobile-card-body {
      padding: 0 16px 16px 16px;
    }

    /* Baris detail di dalam accordion */
    .mobile-detail-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 0;
      border-bottom: 1px solid #F3F4F6;
    }

    .mobile-detail-row:last-child {
      border-bottom: none;
      padding-bottom: 0;
    }

    .mobile-detail-label {
      color: #9CA3AF;
      font-size: 13px;
    }

    .mobile-detail-value {
      color: #374151;
      font-size: 13px;
      font-weight: 500;
      text-align: right;
    }

    /* Tombol chevron/panah expand */
    .btn-collapse {
      background: #F3F4F6;
      border: none;
      border-radius: 6px;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #4B5563;
    }

    /* Efek rotasi ikon chevron saat dibuka */
    .btn-collapse[aria-expanded="true"] iconify-icon {
      transform: rotate(180deg);
    }

    .btn-collapse iconify-icon {
      transition: transform 0.3s ease;
    }
  }
</style>

<h2 class="page-title">Manajemen Verifikasi Data</h2>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 13px;">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 10px;"></button>
</div>
@endif

<div class="table-container mb-5">

  <form action="{{ route('umkm.index') }}" method="GET">
    <!-- Menggunakan g-2 untuk jarak antar baris form di HP -->
    <div class="row mb-3 align-items-center g-2">

      <!-- Baris 1 di HP (100% width) / Kolom kiri di Desktop -->
      <div class="col-12 col-md-4">
        <div class="input-group custom-search-group w-100">
          <span class="input-group-text search-icon-span">
            <iconify-icon icon="lucide:search" style="font-size: 16px;"></iconify-icon>
          </span>
          <input type="text" name="search" class="form-control ps-0 search-input-custom" placeholder="Cari UMKM" value="{{ request('search') }}">
        </div>
      </div>

      <!-- Spasi Desktop -->
      <div class="col-md-2 d-none d-md-block"></div>

      <!-- Baris 2 di HP (Dibagi 50% / col-6) / Kolom Kanan di Desktop -->
      <div class="col-6 col-md-3">
        <select name="status_verif" class="form-select filter-select-custom" onchange="this.form.submit()">
          <option value="">Status Verifikasi</option>
          <option value="menunggu" {{ request('status_verif') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
          <option value="disetujui" {{ request('status_verif') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
          <option value="ditolak" {{ request('status_verif') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
      </div>

      <div class="col-6 col-md-3">
        <select name="status_umkm" class="form-select filter-select-custom" onchange="this.form.submit()">
          <option value="">Status UMKM</option>
          <option value="aktif" {{ request('status_umkm') == 'aktif' ? 'selected' : '' }}>Aktif</option>
          <option value="tidak" {{ request('status_umkm') == 'tidak' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
      </div>

    </div>
  </form>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <!-- Judul Khusus Mobile untuk Accordion Header -->
    <div class="d-block d-md-none fw-bold" style="font-size: 15px; color: #111;">
      Daftar UMKM
    </div>

    <!-- Tombol Tambah Data di kanan -->
    <button type="button" class="btn-primary-custom ms-auto" data-bs-toggle="modal" data-bs-target="#modalTambahData">
      <iconify-icon icon="lucide:plus" style="font-size: 16px;"></iconify-icon> Tambah UMKM
    </button>
  </div>

  <!-- ============================================== -->
  <!-- 1. TAMPILAN TABEL DESKTOP (Sembunyi di Mobile) -->
  <!-- ============================================== -->
  <div class="table-responsive d-none d-md-block">
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
              <button type="button" class="btn-action" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-umkm-id="{{ $umkm->id }}" data-umkm-nama="{{ $umkm->nama }}">
                <iconify-icon icon="lucide:trash-2"></iconify-icon>
              </button>

              <div class="dropdown m-0 p-0">
                <button class="btn-action" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <iconify-icon icon="lucide:more-vertical"></iconify-icon>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius: 8px; font-size: 13px;">
                  @if($umkm->status_verif == 'menunggu')
                  <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('umkm.verifikasi', $umkm->id) }}">
                      Verifikasi Data
                    </a>
                  </li>
                  @else
                  <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('umkm.edit', $umkm->id) }}">
                      Edit Data
                    </a>
                  </li>
                  @endif
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

  <!-- ============================================== -->
  <!-- 2. TAMPILAN ACCORDION MOBILE (Sembunyi di Desktop) -->
  <!-- ============================================== -->
  <div class="d-block d-md-none">

    <!-- Background Header Daftar UMKM -->
    <div class="bg-light p-3" style="border-radius: 8px 8px 0 0; border: 1px solid #E5E7EB; border-bottom: none;"></div>

    <div class="accordion" id="accordionUMKM">
      @forelse ($umkms as $index => $umkm)
      <div class="mobile-card">
        <!-- HEADER ACCORDION -->
        <div class="mobile-card-header" id="heading{{ $umkm->id }}">
          <div>
            <div style="font-weight: 600; font-size: 15px; color: #111; margin-bottom: 8px;">{{ $umkm->nama }}</div>
            <div class="d-flex gap-2 flex-wrap">
              @if($umkm->status_verif == 'disetujui')
              <span class="badge-custom badge-disetujui">Disetujui</span>
              @elseif($umkm->status_verif == 'menunggu')
              <span class="badge-custom badge-menunggu">Menunggu</span>
              @else
              <span class="badge-custom badge-ditolak">Ditolak</span>
              @endif

              @if($umkm->status_umkm == 'aktif')
              <span class="badge-custom badge-aktif">Aktif</span>
              @else
              <span class="badge-custom badge-tidak-aktif">Tidak Aktif</span>
              @endif
            </div>
          </div>
          <!-- Tombol Panah (Collapsed secara default) -->
          <button class="btn-collapse collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $umkm->id }}" aria-expanded="false" aria-controls="collapse{{ $umkm->id }}">
            <iconify-icon icon="lucide:chevron-down"></iconify-icon>
          </button>
        </div>

        <!-- ISI ACCORDION (Tersembunyi jika belum diklik) -->
        <div id="collapse{{ $umkm->id }}" class="collapse" aria-labelledby="heading{{ $umkm->id }}" data-bs-parent="#accordionUMKM">
          <div class="mobile-card-body">

            <div class="mobile-detail-row">
              <span class="mobile-detail-label">Alamat</span>
              <span class="mobile-detail-value">{{ $umkm->alamat }}</span>
            </div>

            <div class="mobile-detail-row">
              <span class="mobile-detail-label">Kelurahan</span>
              <span class="mobile-detail-value">{{ $umkm->kelurahan ? $umkm->kelurahan->nama_kelurahan : '-' }}</span>
            </div>

            <div class="mobile-detail-row">
              <span class="mobile-detail-label">Kategori</span>
              <span class="mobile-detail-value">{{ $umkm->kategori ? $umkm->kategori->kategori_umkm : '-' }}</span>
            </div>

            <!-- Baris Aksi -->
            <div class="mobile-detail-row align-items-center">
              <span class="mobile-detail-label">Aksi</span>
              <div class="d-flex gap-3">
                <!-- Tombol Hapus -->
                <button type="button" class="btn-action p-0" data-bs-toggle="modal" data-bs-target="#deleteModal" data-umkm-id="{{ $umkm->id }}" data-umkm-nama="{{ $umkm->nama }}">
                  <iconify-icon icon="lucide:trash-2"></iconify-icon>
                </button>

                <!-- Tombol Edit/Verifikasi khusus Mobile -->
                @if($umkm->status_verif == 'menunggu')
                <a href="{{ route('umkm.verifikasi', $umkm->id) }}" class="btn-action p-0 text-decoration-none" title="Verifikasi">
                  <iconify-icon icon="lucide:check-circle"></iconify-icon>
                </a>
                @else
                <a href="{{ route('umkm.edit', $umkm->id) }}" class="btn-action p-0 text-decoration-none" title="Edit">
                  <iconify-icon icon="lucide:edit"></iconify-icon>
                </a>
                @endif
              </div>
            </div>

          </div>
        </div>
      </div>
      @empty
      <div class="text-center py-4" style="color: #9CA3AF; border: 1px solid #E5E7EB; border-radius: 0 0 8px 8px; border-top: none;">
        Belum ada data UMKM.
      </div>
      @endforelse
    </div>
  </div>

  <!-- Pagination -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2" style="font-size: 12px; color: #9CA3AF;">
    <div>
      Menampilkan {{ $umkms->firstItem() ?? 0 }} - {{ $umkms->lastItem() ?? 0 }} dari {{ $umkms->total() }} data
    </div>
    <div style="transform: scale(0.9); transform-origin: center right;">
      {{ $umkms->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
  </div>

</div>

<!-- SISA KODE MODAL HAPUS, MODAL PILIH TAMBAH, DAN SCRIPT BAWAAN ANDA TETAP SAMA -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.08);">
      <div class="modal-header border-0 pb-0 mt-2 mx-2">
        <h5 class="modal-title" id="deleteModalLabel" style="font-weight: 600; color: var(--color-black); font-size: 18px;">Hapus Data UMKM</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body border-0 pt-3 pb-4 mx-2">
        <p style="font-size: 14px; color: var(--color-black); margin-bottom: 12px;">
          Apakah Anda yakin ingin menghapus data UMKM <strong id="modal-nama-umkm">"Nama UMKM"</strong>?
        </p>
        <div class="d-flex align-items-center gap-2" style="font-size: 12px; color: #9CA3AF;">
          <iconify-icon icon="lucide:alert-triangle" style="color: var(--color-orange); font-size: 16px;"></iconify-icon>
          <span>Anda tidak bisa mengembalikan data yang sudah dihapus.</span>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 mx-2 mb-2 d-flex justify-content-end gap-2">
        <form id="formDeleteData" method="POST" action="" class="m-0 p-0">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn-modal-hapus">Hapus</button>
        </form>
        <button type="button" class="btn-modal-batal" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.08);">
      <div class="modal-header border-0 pb-0 mt-2 mx-2">
        <h5 class="modal-title" id="modalTambahDataLabel" style="font-weight: 700; color: var(--color-black); font-size: 18px;">Pilih Metode Tambah Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body border-0 pt-3 pb-4 mx-2">
        <div class="d-flex flex-column gap-3">
          <a href="{{ route('umkm.import.form') }}" class="btn-choice">
            <div class="icon-box">
              <iconify-icon icon="lucide:file-spreadsheet"></iconify-icon>
            </div>
            <div class="text-box">
              <span class="title">Import dari Spreadsheet</span>
              <span class="subtitle">Tambahkan banyak data sekaligus menggunakan file CSV.</span>
            </div>
          </a>
          <a href="{{ route('umkm.create') }}" class="btn-choice">
            <div class="icon-box">
              <iconify-icon icon="lucide:keyboard"></iconify-icon>
            </div>
            <div class="text-box">
              <span class="title">Input Data Manual</span>
              <span class="subtitle">Masukkan data UMKM baru satu per satu melalui formulir.</span>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
      deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const umkmId = button.getAttribute('data-umkm-id');
        const umkmNama = button.getAttribute('data-umkm-nama');
        const modalTextNama = deleteModal.querySelector('#modal-nama-umkm');
        modalTextNama.textContent = '"' + umkmNama + '"';
        const formDelete = deleteModal.querySelector('#formDeleteData');
        formDelete.action = "{{ url('/admin/umkm') }}/" + umkmId;
      });
    }
  });
</script>

@if(session('wa_rejected'))
@php
$wa_data = session('wa_rejected');
$nomor_hp = preg_replace('/[^0-9]/', '', $wa_data['kontak']);
if (str_starts_with($nomor_hp, '0')) {
$nomor_hp = '62' . substr($nomor_hp, 1);
}
$pesan = "Halo, kami dari Admin SI Data UMKM Kecamatan Bacukiki.\n\n";
$pesan .= "Mohon maaf, pendaftaran data untuk UMKM *{$wa_data['nama']}* saat ini belum dapat kami setujui.\n";
$pesan .= "*Alasan Penolakan:*{$wa_data['alasan']}\n\n";
$pesan .= "Silakan perbaiki data Anda dan lakukan pengajuan ulang melalui tautan berikut:\n";
$pesan .= "https://forms.gle/Bu7sdaRdWGAXTXUn6nn";
$pesan .= "Terima kasih.";
$link_wa = "https://wa.me/" . $nomor_hp . "?text=" . urlencode($pesan);
@endphp
<div class="modal fade" id="waSuccessModal" tabindex="-1" aria-labelledby="waSuccessModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 12px; border: none;">
      <div class="modal-body text-center p-5">
        <div class="mb-4">
          <iconify-icon icon="lucide:check-circle-2" style="font-size: 64px; color: var(--color-green);"></iconify-icon>
        </div>
        <h4 class="mb-2" style="font-weight: 700; color: var(--color-gray);">Verifikasi Selesai</h4>
        <p class="mb-4" style="color: var(--color-gray-700); font-size: 14px;">Data UMKM <strong>{{ $wa_data['nama'] }}</strong> telah disimpan dengan status Ditolak. Silakan hubungi pemilik UMKM untuk memberitahukan alasan penolakan.</p>
        <div class="d-flex justify-content-center gap-3">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Tutup</button>
          <a href="{{ $link_wa }}" target="_blank" class="btn btn-success d-flex align-items-center gap-2" style="border-radius: 8px; font-weight: 500; background-color: #41644A; border: none;">
            <iconify-icon icon="lucide:message-circle" style="font-size: 18px;"></iconify-icon>
            Kirim Pesan WhatsApp
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var waModal = new bootstrap.Modal(document.getElementById('waSuccessModal'));
    waModal.show();
  });
</script>
@endif
@endsection