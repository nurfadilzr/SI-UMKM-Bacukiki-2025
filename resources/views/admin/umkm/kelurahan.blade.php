@extends('layouts.app')

@section('content')
<style>
  .page-title {
    font-weight: 700;
    font-size: 22px;
    color: var(--color-black);
    margin-bottom: 24px;
  }

  .add-card {
    border-radius: 8px;
    border: 1px solid var(--color-gray-50);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
    padding: 20px;
  }

  .add-card-title {
    font-weight: 600;
    font-size: 16px;
    color: var(--color-black);
  }

  .form-control {
    border-radius: 4px;
    border: 1px solid var(--color-gray-500);
    font-size: 14px;
  }

  .btn-tambah {
    background-color: #49628C;
    /* Menggunakan hex var(--color-blue-700) */
    color: white;
    border-radius: 4px;
    padding: 8px 16px;
    font-size: 14px;
    border: none;
    font-weight: 500;
    white-space: nowrap;
    /* Mencegah teks tombol patah ke bawah */
  }

  .btn-tambah:hover {
    background-color: #1B3B6F;
    /* var(--color-blue) */
    color: #F3F4F6;
  }

  .table-card-title {
    font-weight: 600;
    font-size: 20px;
    color: var(--color-black);
  }

  .custom-table th {
    font-weight: 500;
    color: var(--color-gray);
    background-color: var(--color-gray-light);
    border-bottom: 1px solid var(--color-border);
    padding: 12px 14px;
    font-size: 13px;
    white-space: nowrap;
    /* Mencegah header tabel patah */
  }

  .custom-table td {
    padding: 12px 14px;
    vertical-align: middle;
    font-size: 13px;
    color: var(--color-gray);
    font-weight: 400;
    border-bottom: 1px solid var(--color-border);
  }

  .btn-action-icon {
    padding: 8px 10px;
    border-radius: 6px;
    color: #404040;
    transition: all 0.2s ease-in-out;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    border: none;
    background: transparent;
  }

  .btn-action-icon:hover {
    background-color: #ECECEC;
    color: #111;
  }

  .btn-batal {
    background-color: white;
    color: var(--color-gray);
    border: 1.5px solid var(--color-gray-500);
    border-radius: 6px;
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.1s;
  }

  .btn-batal:hover {
    background-color: var(--color-gray-50);
    border: 1.5px solid var(--color-gray-500);
  }

  .btn-simpan {
    background-color: #54745C;
    /* var(--color-green-800) */
    color: white;
    border: none;
    border-radius: 6px;
    padding: 8px 14px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
  }

  .btn-simpan:hover {
    color: white;
    background-color: #41644A;
    /* var(--color-green) */
  }

  .btn-hapus {
    background-color: #D17A22;
    /* var(--color-orange) */
    color: #FFFFFF;
    border: none;
    border-radius: 6px;
    padding: 8px 20px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
  }

  .btn-hapus:hover {
    opacity: 0.9;
    color: white;
  }

  /* Lebar default form pencarian (Desktop) */
  .search-form-custom {
    width: 250px;
    position: relative;
  }

  /* =========================================
     === CSS RESPONSIVE KHUSUS MOBILE ===
     ========================================= */
  @media (max-width: 991.98px) {
    .page-title {
      font-size: 20px;
      margin-bottom: 16px;
    }

    .table-card-title {
      font-size: 18px;
    }

    /* Mengubah form search menjadi lebar 100% di HP */
    .search-form-custom {
      width: 100%;
    }

    .custom-table th,
    .custom-table td {
      padding: 10px 8px;
      /* Mengurangi padding tabel agar lebih muat di HP */
    }

    .modal-custom-width {
      width: calc(100% - 32px) !important;
      /* Lebar 100% dikurangi margin 16px kiri & 16px kanan */
      margin-left: auto !important;
      margin-right: auto !important;
    }
  }
</style>

<div class="container-fluid p-3 p-md-4">
  <h3 class="page-title">Tambah Kelurahan</h3>
  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
  @if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="row">
    <div class="col-lg-5 mb-4">
      <div class="card add-card bg-white">
        <h6 class="add-card-title mb-3">Tambah Kelurahan Baru</h6>

        <form action="{{ route('kelurahan.store') }}" method="POST">
          @csrf
          <div class="d-flex gap-2">
            <input type="text" name="nama_kelurahan" class="form-control flex-grow-1 @error('nama_kelurahan') is-invalid @enderror" placeholder="Masukkan kelurahan baru" required style="min-width: 0;">
            <button type="submit" class="btn-tambah flex-grow-1 flex-md-grow-0">Tambah</button>
          </div>
          @error('nama_kelurahan')
          <small class="text-danger mt-1 d-block">{{ $message }}</small>
          @enderror
        </form>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="card p-3 p-md-4 bg-white" style="border-radius: 12px; border: 1px solid #E5E7EB; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
          <h4 class="table-card-title mb-0">Daftar Kelurahan</h4>

          <form action="{{ route('kelurahan.index') }}" method="GET" class="search-form-custom">
            <iconify-icon icon="lucide:search" style="position: absolute; left: 12px; top: 10px; color: #8C8C8C; font-size: 16px;"></iconify-icon>
            <input type="text" name="search" class="form-control w-100" placeholder="Cari Kelurahan" value="{{ request('search') }}" style="padding-left: 38px; font-size: 13px; border-radius: 6px; color: #404040;">
          </form>
        </div>

        <div class="table-responsive">
          <table class="table custom-table align-middle mb-0">
            <thead style="background-color: #F8FAFC;">
              <tr>
                <th>Nama Kelurahan</th>
                <th>Jumlah UMKM</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($kelurahans as $kelurahan)
              <tr>
                <td style="font-weight: 500; color: #111;">{{ $kelurahan->nama_kelurahan }}</td>
                <td>{{ $kelurahan->umkm_count }}</td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn-action-icon" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $kelurahan->id }}">
                      <iconify-icon icon="lucide:edit" style="font-size: 18px;"></iconify-icon>
                    </button>
                    <button class="btn-action-icon" data-bs-toggle="modal" data-bs-target="#modalDelete{{ $kelurahan->id }}">
                      <iconify-icon icon="lucide:trash-2" style="font-size: 18px;"></iconify-icon>
                    </button>
                  </div>
                </td>
              </tr>

              <div class="modal fade" id="modalEdit{{ $kelurahan->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-custom-width">
                  <div class="modal-content" style="border-radius: 12px;">
                    <form action="{{ route('kelurahan.update', $kelurahan->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" style="font-weight: 600; font-size: 18px;">Edit Kelurahan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <label class="form-label" style="font-size: 14px; font-weight: 600; color: #333;">Nama Kelurahan</label>
                        <input type="text" name="nama_kelurahan" class="form-control" value="{{ $kelurahan->nama_kelurahan }}" required style="border-radius: 6px; font-size: 14px; padding: 10px;">
                      </div>
                      <div class="modal-footer border-0">
                        <button type="button" class="btn btn-batal" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="modalDelete{{ $kelurahan->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-custom-width">
                  <div class="modal-content" style="border-radius: 12px;">
                    <form action="{{ route('kelurahan.destroy', $kelurahan->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <div class="modal-body text-center p-4">
                        <iconify-icon icon="lucide:alert-triangle" style="font-size: 48px; color: #D17A22; margin-bottom: 16px;"></iconify-icon>
                        <h4 style="font-weight: 600; font-size: 20px; color: #111;">Hapus Kelurahan?</h4>
                        <p style="font-size: 14px; color: #666; margin-bottom: 24px;">Apakah Anda yakin ingin menghapus kelurahan <strong>"{{ $kelurahan->nama_kelurahan }}"</strong>? Data yang dihapus tidak dapat dikembalikan.</p>

                        <div class="d-flex justify-content-center gap-2">
                          <button type="submit" class="btn btn-hapus">Ya, Hapus</button>
                          <button type="button" class="btn btn-batal" data-bs-dismiss="modal">Batal</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              @empty
              <tr>
                <td colspan="3" class="text-center text-muted py-4">
                  Belum ada data kelurahan atau pencarian tidak ditemukan.
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection