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
    /* Membuat latar belakang gelap 30% */
  }

  .btn-modal-batal {
    background-color: white;
    color: var(--color-gray);
    border: 1.5px solid var(--color-gray-500);
    border-radius: 6px;
    padding: 8px 16px;
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
              <!-- <form action="{{ route('umkm.destroy', $umkm->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="m-0 p-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-action" title="Hapus"><iconify-icon icon="lucide:trash-2"></iconify-icon></button>
              </form> -->
              <button type="button" class="btn-action" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-umkm-id="{{ $umkm->id }}" data-umkm-nama="{{ $umkm->nama }}">
                <iconify-icon icon="lucide:trash-2"></iconify-icon>
              </button>

              <div class="dropdown m-0 p-0">
                <button class="btn-action" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <iconify-icon icon="lucide:more-vertical"></iconify-icon>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius: 8px; font-family: 'Lato', sans-serif; font-size: 13px;">
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

  <div class="d-flex justify-content-between align-items-center mt-3" style="font-size: 12px; color: #9CA3AF;">
    <div>
      Menampilkan {{ $umkms->firstItem() ?? 0 }} - {{ $umkms->lastItem() ?? 0 }} dari {{ $umkms->total() }} data
    </div>
    <div style="transform: scale(0.9); transform-origin: right center;">
      {{ $umkms->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
  </div>

</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.08);">

      <div class="modal-header border-0 pb-0 mt-2 mx-2">
        <h5 class="modal-title" id="deleteModalLabel" style="font-weight: 700; color: var(--color-black); font-size: 18px;">Hapus Data UMKM</h5>
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

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('deleteModal');

    if (deleteModal) {
      deleteModal.addEventListener('show.bs.modal', function(event) {
        // Menangkap tombol tong sampah yang baru saja diklik
        const button = event.relatedTarget;

        // Mengambil ID dan Nama dari atribut data-* tombol tersebut
        const umkmId = button.getAttribute('data-umkm-id');
        const umkmNama = button.getAttribute('data-umkm-nama');

        // Mengganti teks nama UMKM di dalam modal
        const modalTextNama = deleteModal.querySelector('#modal-nama-umkm');
        modalTextNama.textContent = '"' + umkmNama + '"';

        // Mengubah URL 'action' pada form hapus agar sesuai dengan ID yang dipilih
        // Pastikan URL dasar ini sesuai dengan route laravel kamu
        const formDelete = deleteModal.querySelector('#formDeleteData');
        formDelete.action = "{{ url('/admin/umkm') }}/" + umkmId;
      });
    }
  });
</script>
@endsection