@extends('layouts.app') @section('content')

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
    padding: 20px 20px;
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
    background-color: var(--color-blue-700);
    color: white;
    border-radius: 4px;
    padding: 8px 12px;
    font-size: 14px;
    border: none;
  }

  .btn-tambah:hover {
    background-color: var(--color-blue);
    color: var(--color-gray-light);
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
    /* Warna kotak abu-abu terang */
    color: #111;
    /* Ikon menjadi sedikit lebih gelap agar kontras */
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
    background-color: var(--color-green-800);
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
    background-color: var(--color-green);
  }

  .btn-hapus {
    background-color: var(--color-orange);
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
</style>

<div class="container-fluid">
  <h3 class="page-title">Tambah Kategori UMKM</h3>

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
    <div class="col-md-4 mb-4">
      <div class="card add-card">
        <h6 class="add-card-title">Tambah Kategori Baru</h6>

        <form action=" {{ route('kategori.store') }}" method="POST">
          @csrf
          <div class="d-flex gap-2">
            <input type="text" name="kategori_umkm" class="form-control @error('kategori_umkm') is-invalid @enderror" placeholder="Masukkan kategori UMKM" required>

            <button type="submit" class="btn-tambah">Tambah</button>
          </div>
          @error('kategori_umkm')
          <small class="text-danger mt-1 d-block">{{ $message }}</small>
          @enderror
        </form>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card p-4" style="border-radius: 12px; border: 1px solid #E5E7EB; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="table-card-title">Daftar Kategori UMKM</h4>

          <form action="{{ route('kategori.index') }}" method="GET" style="width: 250px; position: relative;">
            <iconify-icon icon="lucide:search" style="position: absolute; left: 12px; top: 7px; color: var(--color-gray-500);"></iconify-icon>
            <input type="text" name="search" class="form-control" placeholder="Cari Kategori UMKM" value="{{ request('search') }}" style="padding-left: 35px; font-size: 12px; border-radius: 4px; color: var(--color-gray-500);">
          </form>
        </div>

        <div class="table-responsive">
          <table class="table custom-table align-middle">
            <thead style="background-color: #F8FAFC;">
              <tr>
                <th>Jenis Kategori</th>
                <th>Jumlah UMKM</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($kategoris as $kategori)
              <tr>
                <td>{{ $kategori->kategori_umkm }}</td>
                <td>{{ $kategori->umkm_count }}</td>
                <td>
                  <div class="d-flex" style="margin-left: -10px;">
                    <button class="btn-action-icon" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $kategori->id }}">
                      <iconify-icon icon="lucide:edit" style="font-size: 18px; color: var(--color-gray);"></iconify-icon>
                    </button>
                    <button class="btn-action-icon" data-bs-toggle="modal" data-bs-target="#modalDelete{{ $kategori->id }}">
                      <iconify-icon icon="lucide:trash-2" style="font-size: 18px; color: var(--color-gray);"></iconify-icon>
                    </button>
                  </div>
                </td>
              </tr>

              <div class="modal fade" id="modalEdit{{ $kategori->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content" style="border-radius: 12px;">
                    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" style="font-weight: 600; font-size: 18px;">Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <label class="form-label" style="border-radius: 6px; font-size: 16px; font-weight: 500;">Nama Kategori</label>
                        <input type="text" name="kategori_umkm" class="form-control" value="{{ $kategori->kategori_umkm }}" required style="border-radius: 6px; font-size: 13px; padding: 10px;">
                      </div>
                      <div class="modal-footer border-0">
                        <button type="button" class="btn btn-batal" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="modalDelete{{ $kategori->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content" style="border-radius: 12px;">
                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <div class="modal-body text-center p-4">
                        <iconify-icon icon="lucide:alert-triangle" style="font-size: 48px; color: var(--color-orange); margin-bottom: 16px;"></iconify-icon>
                        <h4 style="font-weight: 600; font-size: 20px; ">Hapus Kategori?</h4>
                        <p style="font-size: 14px; color: var(--color-gray);">Apakah Anda yakin ingin menghapus kategori <strong>"{{ $kategori->kategori_umkm }}"</strong>? Data yang dihapus tidak dapat dikembalikan.</p>

                        <div class="d-flex justify-content-center gap-2">
                          <button type=" submit" class="btn btn-hapus">Ya, Hapus</button>
                          <button type="button" class="btn btn-batal" data-bs-dismiss="modal">Batal</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              @empty
              <tr>
                <td colspan=" 3" class="text-center text-muted py-4">
                  Belum ada data kategori atau pencarian tidak ditemukan.
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