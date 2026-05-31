@extends('layouts.app') @section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  .page-title {
    font-weight: 700;
    font-size: 24px;
    color: var(--color-black);
    margin-bottom: 0;
  }

  .form-select-custom {
    display: block;
    width: 150px;
    padding: 10px 14px;
    font-size: 13px;
    color: var(--color-black);
    background-color: #FFFFFF;
    border: 1px solid #9CA3AF;
    border-radius: 6px;
    margin: 0;

    /* Menghilangkan panah dropdown jadul bawaan browser */
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;

    /* Menggantinya dengan panah custom yang lebih modern */
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%239CA3AF' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 14px center;
    background-size: 14px 10px;
    transition: border-color 0.2s;

  }

  .form-select-custom:focus {
    border-color: var(--color-green);
    box-shadow: 0 0 0 0.15rem var(--color-green-light);
    outline: none;
  }

  .card-title {
    font-size: 13px;
    color: var(--color-black);
    font-weight: 500;
  }
</style>

<div class="container-fluid" style="background-color: #F3F4F6; min-height: 100vh; padding: 16px 24px;">

  <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: -20px;">
    <h2 class="page-title">Dashboard</h2>
    <select class="form-select form-select-custom" onchange="window.location.href='?filter=' + this.value">
      <option value="semua" {{ request('filter', 'semua') == 'semua' ? 'selected' : '' }}>Filter</option>
      <option value="bulan_ini" {{ request('filter') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
      <option value="3_bulan" {{ request('filter') == '3_bulan' ? 'selected' : '' }}>3 Bulan Terakhir</option>
      <option value="6_bulan" {{ request('filter') == '6_bulan' ? 'selected' : '' }}>6 Bulan Terakhir</option>
      <option value="tahun_ini" {{ request('filter') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
    </select>
  </div>

  <div class=" row g-3 mb-3">

    <div class="col-md-3 d-flex flex-column gap-3">
      <div class="card p-3 border-0 flex-grow-1 d-flex flex-row align-items-center gap-3" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <div style="background-color: var(--color-green-300); padding: 12px; border-radius: 50%; align-content: center; justify-content: center; width: 48px; height: 48px;">
          <iconify-icon icon="lucide:store" style="font-size: 24px; color: var(--color-green);"></iconify-icon>
        </div>
        <div>
          <div class="card-title">Total UMKM</div>
          <div style="font-size: 26px; font-weight: bold; color: var(--color-black); line-height: 1.2;">{{ $totalUmkm }}</div>
        </div>
      </div>

      <div class="card p-3 border-0 flex-grow-1 d-flex flex-row align-items-center gap-3" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <div style="background-color: var(--color-orange-200); padding: 12px; border-radius: 50%; align-content: center; justify-content: center; width: 48px; height: 48px;">
          <iconify-icon icon="lucide:clipboard-list" style="font-size: 24px; color: var(--color-orange);"></iconify-icon>
        </div>
        <div>
          <div class="card-title">Status Belum Disetujui</div>
          <div style="font-size: 26px; font-weight: bold; color: var(--color-black); line-height: 1.2;">{{ $totalMenunggu }}</div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-3 border-0 h-100" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h6 class="card-title">Status UMKM</h6>
        <div style="position: relative; height: 130px; width: 100%; display: flex; justify-content: center;">
          <canvas id="pieStatusUMKM"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-5">
      <div class="card p-3 border-0 h-100" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h6 class="card-title">Status Verifikasi Data</h6>
        <div style="position: relative; height: 130px; width: 100%; display: flex; justify-content: center;">
          <canvas id="doughnutVerifikasi"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">

    <div class="col-md-8 d-flex flex-column gap-3">
      <div class="card p-3 border-0" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h6 class="card-title">Jumlah UMKM tiap Kelurahan</h6>
        <div style="position: relative; height: 160px; width: 100%;">
          <canvas id="barKelurahan"></canvas>
        </div>
      </div>

      <div class="card p-3 border-0 flex-grow-1" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h6 class="card-title">Data UMKM yang Belum Disetujui</h6>
          <a href="{{ route('umkm.index') }}" style="font-size: 12px; text-decoration: underline; color: var(--color-blue); font-weight: 500;">Lihat Semua</a>
        </div>

        <div class="table-responsive">
          <table class="table table-borderless mb-0" style="font-size: 13px;">
            <tbody style="border: 1px solid #E5E7EB; border-radius: 8px;">
              @forelse($umkmMenunggu as $umkm)
              <tr style="border-bottom: 1px solid #E5E7EB;">
                <td class="py-2 px-3 text-secondary">{{ $umkm->nama }}</td>
                <td class="py-2 text-secondary">{{ $umkm->kelurahan ? $umkm->kelurahan->nama_kelurahan : '-' }}</td>
                <td class="py-2 text-secondary">{{ $umkm->kategori ? $umkm->kategori->kategori_umkm : '-' }}</td>
                <td class="py-2 text-end px-3">
                  <span style="background-color: #FEEED7; color: var(--color-orange); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                    {{ ucfirst($umkm->status_verif) }}
                  </span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="py-3 text-center text-secondary">Tidak ada data.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-3 border-0 h-100" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h6 class="card-title">Penambahan UMKM tiap Bulan</h6>
        <div style="position: relative; height: 100%; min-height: 280px; width: 100%;">
          <canvas id="barBulan"></canvas>
        </div>
      </div>
    </div>

  </div>
</div>

<div id="data-grafik"
  data-pie="{{ json_encode([$statusAktif, $statusTidakAktif]) }}"
  data-doughnut="{{ json_encode([$verifDisetujui, $verifMenunggu, $verifDitolak]) }}"
  data-kelurahan-labels="{{ json_encode($labelKelurahan) }}"
  data-kelurahan-angka="{{ json_encode($angkaKelurahan) }}"
  data-bulan-labels="{{ json_encode($namaBulan) }}"
  data-bulan-angka="{{ json_encode($angkaBulan) }}"
  style="display: none;">
</div>

<!-- <div class="container-fluid" style="background-color: #F3F4F6; min-height: 100vh; padding: 24px;">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="font-weight-bold mb-0" style="color: #111;">Dashboard</h3>
    <select class="form-select" style="width: 150px; border-radius: 8px;">
      <option>Filter</option>
      <option>Bulan Ini</option>
      <option>Tahun Ini</option>
    </select>
  </div>

  <div class="row g-4 mb-4">

    <div class="col-md-3 d-flex flex-column gap-4">
      <div class="card p-3 border-0 flex-grow-1 d-flex flex-row align-items-center gap-3" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <div style="background-color: #E2E8F0; padding: 16px; border-radius: 50%;">
          <iconify-icon icon="lucide:store" style="font-size: 28px; color: var(--color-green);"></iconify-icon>
        </div>
        <div>
          <div style="font-size: 14px; color: #475569; font-weight: 500;">Total UMKM</div>
          <div style="font-size: 32px; font-weight: bold; color: #111;">{{ $totalUmkm }}</div>
        </div>
      </div>

      <div class="card p-3 border-0 flex-grow-1 d-flex flex-row align-items-center gap-3" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <div style="background-color: var(--color-orange-200); padding: 16px; border-radius: 50%;">
          <iconify-icon icon="lucide:clipboard-list" style="font-size: 28px; color: var(--color-orange);"></iconify-icon>
        </div>
        <div>
          <div style="font-size: 14px; color: #475569; font-weight: 500;">Status Belum Disetujui</div>
          <div style="font-size: 32px; font-weight: bold; color: #111;">{{ $totalMenunggu }}</div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-4 border-0 h-100" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h6 class="font-weight-bold mb-4">Status UMKM</h6>
        <div style="position: relative; height: 180px; width: 100%; display: flex; justify-content: center;">
          <canvas id="pieStatusUMKM"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-5">
      <div class="card p-4 border-0 h-100" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h6 class="font-weight-bold mb-4">Status Verifikasi Data</h6>
        <div style="position: relative; height: 180px; width: 100%; display: flex; justify-content: center;">
          <canvas id="doughnutVerifikasi"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">

    <div class="col-md-8 d-flex flex-column gap-4">
      <div class="card p-4 border-0" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h6 class="font-weight-bold mb-4">Jumlah UMKM tiap Kelurahan</h6>
        <div style="position: relative; height: 250px; width: 100%;">
          <canvas id="barKelurahan"></canvas>
        </div>
      </div>

      <div class="card p-4 border-0 flex-grow-1" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h6 class="font-weight-bold mb-0">Data UMKM yang Belum Disetujui</h6>
          <a href="#" style="font-size: 13px; text-decoration: none; color: #5C6E8F; font-weight: 500;">Lihat Semua</a>
        </div>

        <table class="table table-borderless mb-0">
          <tbody style="border: 1px solid #E5E7EB; border-radius: 8px;">
            @forelse($umkmMenunggu as $umkm)
            <tr style="border-bottom: 1px solid #E5E7EB;">
              <td class="py-3 px-4 text-secondary">{{ $umkm->nama }}</td>
              <td class="py-3 text-secondary">{{ $umkm->kelurahan ? $umkm->kelurahan->nama_kelurahan : '-' }}</td>
              <td class="py-3 text-secondary">{{ $umkm->kategori ? $umkm->kategori->kategori_umkm : '-' }}</td>
              <td class="py-3 text-end px-4">
                <span style="background-color: #FEEED7; color: var(--color-orange); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                  {{ ucfirst($umkm->status_verif) }}
                </span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="py-4 text-center text-secondary">Tidak ada data UMKM yang menunggu persetujuan.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-4 border-0 h-100" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h6 class="font-weight-bold mb-4">Penambahan UMKM tiap Bulan</h6>
        <div style="position: relative; height: 100%; min-height: 400px; width: 100%;">
          <canvas id="barBulan"></canvas>
        </div>
      </div>
    </div>

  </div>
</div> -->

<!-- <div id="data-grafik"
  data-pie="{{ json_encode([$statusAktif, $statusTidakAktif]) }}"
  data-doughnut="{{ json_encode([$verifDisetujui, $verifMenunggu, $verifDitolak]) }}"
  data-kelurahan-labels="{{ json_encode($labelKelurahan) }}"
  data-kelurahan-angka="{{ json_encode($angkaKelurahan) }}"
  data-bulan-labels="{{ json_encode($namaBulan) }}"
  data-bulan-angka="{{ json_encode($angkaBulan) }}"
  style="display: none;">
</div> -->

<!-- <script>
  document.addEventListener('DOMContentLoaded', function() {
    // 1. Ambil semua data dari HTML tersembunyi
    const elemenGrafik = document.getElementById('data-grafik');

    const pieData = JSON.parse(elemenGrafik.getAttribute('data-pie'));
    const doughnutData = JSON.parse(elemenGrafik.getAttribute('data-doughnut'));
    const kelurahanLabels = JSON.parse(elemenGrafik.getAttribute('data-kelurahan-labels'));
    const kelurahanAngka = JSON.parse(elemenGrafik.getAttribute('data-kelurahan-angka'));
    const bulanLabels = JSON.parse(elemenGrafik.getAttribute('data-bulan-labels'));
    const bulanAngka = JSON.parse(elemenGrafik.getAttribute('data-bulan-angka'));

    // Konfigurasi Umum Chart.js
    Chart.defaults.font.family = "'Inter', 'Segoe UI', sans-serif";
    Chart.defaults.color = '#6B7280';
    Chart.defaults.scale.grid.color = '#F3F4F6';

    // 1. PIE CHART (Status UMKM)
    new Chart(document.getElementById('pieStatusUMKM'), {
      type: 'pie',
      data: {
        labels: ['Aktif', 'Tidak Aktif'],
        datasets: [{
          data: pieData, // <-- Memanggil variabel JS yang bersih
          backgroundColor: ['#1E3A8A', '#4B5563'],
          borderWidth: 2,
          borderColor: '#ffffff'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right',
            labels: {
              usePointStyle: true,
              boxWidth: 8
            }
          }
        }
      }
    });

    // 2. DOUGHNUT CHART (Status Verifikasi)
    new Chart(document.getElementById('doughnutVerifikasi'), {
      type: 'doughnut',
      data: {
        labels: ['Disetujui', 'Menunggu', 'Ditolak'],
        datasets: [{
          data: doughnutData, // <-- Memanggil variabel JS yang bersih
          backgroundColor: ['var(--color-green)', 'var(--color-orange)', '#4B5563'],
          borderWidth: 2,
          borderColor: '#ffffff'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '60%',
        plugins: {
          legend: {
            position: 'right',
            labels: {
              usePointStyle: true,
              boxWidth: 8
            }
          }
        }
      }
    });

    // 3. VERTICAL BAR CHART (Kelurahan)
    new Chart(document.getElementById('barKelurahan'), {
      type: 'bar',
      data: {
        labels: kelurahanLabels,
        datasets: [{
          label: 'Jumlah UMKM',
          data: kelurahanAngka,
          backgroundColor: 'var(--color-green)',
          borderRadius: 4,
          barThickness: 45
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              borderDash: [5, 5]
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });

    // 4. HORIZONTAL BAR CHART (Bulan)
    new Chart(document.getElementById('barBulan'), {
      type: 'bar',
      data: {
        labels: bulanLabels,
        datasets: [{
          label: 'UMKM Baru',
          data: bulanAngka,
          backgroundColor: '#1E3A8A',
          borderRadius: 4,
          barThickness: 12
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            grid: {
              borderDash: [5, 5]
            },
            suggestedMax: 10
          },
          y: {
            grid: {
              display: false
            }
          }
        }
      }
    });
  });
</script> -->

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const elemenGrafik = document.getElementById('data-grafik');
    const pieData = JSON.parse(elemenGrafik.getAttribute('data-pie'));
    const doughnutData = JSON.parse(elemenGrafik.getAttribute('data-doughnut'));
    const kelurahanLabels = JSON.parse(elemenGrafik.getAttribute('data-kelurahan-labels'));
    const kelurahanAngka = JSON.parse(elemenGrafik.getAttribute('data-kelurahan-angka'));
    const bulanLabels = JSON.parse(elemenGrafik.getAttribute('data-bulan-labels'));
    const bulanAngka = JSON.parse(elemenGrafik.getAttribute('data-bulan-angka'));

    Chart.defaults.font.family = "'Lato', sans-serif";
    Chart.defaults.color = '#404040';
    Chart.defaults.font.size = 11;
    Chart.defaults.scale.grid.color = '#ECECEC';

    new Chart(document.getElementById('pieStatusUMKM'), {
      type: 'pie',
      data: {
        labels: ['Aktif', 'Tidak Aktif'],
        datasets: [{
          data: pieData,
          backgroundColor: ['#1B3B6F', '#404040'],
          borderWidth: 2,
          borderColor: '#ffffff'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right',
            labels: {
              usePointStyle: true,
              boxWidth: 6
            }
          }
        }
      }
    });

    new Chart(document.getElementById('doughnutVerifikasi'), {
      type: 'doughnut',
      data: {
        labels: ['Disetujui', 'Menunggu', 'Ditolak'],
        datasets: [{
          data: doughnutData,
          backgroundColor: ['#41644A', '#D17A22', '#404040'],
          borderWidth: 2,
          borderColor: '#ffffff'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%', // Lubang diperbesar sedikit
        plugins: {
          legend: {
            position: 'right',
            labels: {
              usePointStyle: true,
              boxWidth: 6
            }
          }
        }
      }
    });

    new Chart(document.getElementById('barKelurahan'), {
      type: 'bar',
      data: {
        labels: kelurahanLabels,
        datasets: [{
          label: 'Jumlah UMKM',
          data: kelurahanAngka,
          backgroundColor: '#41644A',
          borderRadius: 6,
          barThickness: 30
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              borderDash: [5, 5]
            },
            ticks: {
              precision: 0, // Memaksa angka bulat (tanpa koma)
              stepSize: 1 // Jarak antar angka minimal 1
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });

    new Chart(document.getElementById('barBulan'), {
      type: 'bar',
      data: {
        labels: bulanLabels,
        datasets: [{
          label: 'UMKM Baru',
          data: bulanAngka,
          backgroundColor: '#1B3B6F',
          borderRadius: 6,
          barThickness: 8
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            grid: {
              borderDash: [5, 5]
            },
            suggestedMax: 10,
            ticks: {
              precision: 0,
              stepSize: 1
            }
          },
          y: {
            grid: {
              display: false
            }
          }
        }
      }
    });
  });
</script>

@endsection