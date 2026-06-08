@extends('layouts.app')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  .page-title {
    font-weight: 700;
    font-size: 24px;
    color: var(--color-black);
    margin-bottom: 0;
  }

  /* CSS Tombol Filter Custom (Desktop) */
  .btn-filter-custom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 160px;
    padding: 10px 14px;
    font-size: 13px;
    color: var(--color-black);
    background-color: #FFFFFF;
    border: 1px solid var(--color-gray-500);
    border-radius: 6px;
    transition: all 0.2s;
  }

  .btn-filter-custom:focus,
  .btn-filter-custom:hover {
    border-color: var(--color-green);
    box-shadow: 0 0 0 0.15rem rgba(65, 100, 74, 0.15);
    /* Bayangan hijau tipis */
  }

  .card-title-custom {
    font-size: 13px;
    color: var(--color-black);
    font-weight: 600;
  }

  .stat-title {
    font-size: 13px;
    color: var(--color-black);
    font-weight: 600;
  }

  .stat-value {
    font-size: 26px;
    font-weight: bold;
    color: var(--color-black);
    line-height: 1.2;
  }

  .icon-box {
    border-radius: 50%;
    align-content: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    flex-shrink: 0;
  }

  .chart-box {
    position: relative;
    height: 120px;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* =========================================
     === CSS KHUSUS MOBILE (RESPONSIVE) ===
     ========================================= */
  @media (max-width: 768px) {
    .page-title {
      font-size: 20px;
    }

    .btn-filter-custom {
      width: 140px;
      padding: 8px 12px;
      font-size: 12px;
    }

    .stat-title {
      font-size: 11px;
    }

    .stat-value {
      font-size: 20px;
    }

    .icon-box {
      width: 36px;
      height: 36px;
    }

    .icon-box iconify-icon {
      font-size: 18px !important;
    }

    .card-title-custom {
      font-size: 12px;
      text-align: center;
    }

    .mobile-gap {
      gap: 10px !important;
    }

    .mobile-p {
      padding: 12px !important;
    }

    /* Merapatkan tabel di HP */
    .table-mobile-text {
      font-size: 11px !important;
    }

    .table-mobile-text td {
      padding: 8px 6px !important;
    }

    .badge-mobile {
      font-size: 10px !important;
      padding: 4px 8px !important;
    }

    .chart-box {
      height: 220px !important;
    }
  }
</style>

<div class="container-fluid mb-5 p-3 p-md-4" style="background-color: var(--color-gray-light); min-height: 100vh;">

  @php
  // Logika untuk menentukan teks label mana yang sedang aktif
  $currentFilter = request('filter', 'semua');
  $filterLabel = 'Filter';

  if ($currentFilter == 'bulan_ini') $filterLabel = 'Bulan Ini';
  elseif ($currentFilter == '3_bulan') $filterLabel = '3 Bulan Terakhir';
  elseif ($currentFilter == '6_bulan') $filterLabel = '6 Bulan Terakhir';
  elseif ($currentFilter == 'tahun_ini') $filterLabel = 'Tahun Ini';
  @endphp

  <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
    <h2 class="page-title">Dashboard</h2>
    <div class="dropdown">
      <button class="btn btn-filter-custom text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="text-truncate">{{ $filterLabel }}</span>
        <iconify-icon icon="lucide:chevron-down" style="color: var(--color-gray-500); min-width: 16px;"></iconify-icon>
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius: 8px; font-size: 13px; border: 1px solid #E5E7EB; padding: 8px 0; min-width: 160px;">
        <li>
          <a class="dropdown-item py-2 {{ $currentFilter == 'semua' ? 'bg-light text-dark fw-bold' : '' }}" href="?filter=semua">Semua</a>
        </li>
        <li>
          <a class="dropdown-item py-2 {{ $currentFilter == 'bulan_ini' ? 'bg-light text-dark fw-bold' : '' }}" href="?filter=bulan_ini">Bulan Ini</a>
        </li>
        <li>
          <a class="dropdown-item py-2 {{ $currentFilter == '3_bulan' ? 'bg-light text-dark fw-bold' : '' }}" href="?filter=3_bulan">3 Bulan Terakhir</a>
        </li>
        <li>
          <a class="dropdown-item py-2 {{ $currentFilter == '6_bulan' ? 'bg-light text-dark fw-bold' : '' }}" href="?filter=6_bulan">6 Bulan Terakhir</a>
        </li>
        <li>
          <a class="dropdown-item py-2 {{ $currentFilter == 'tahun_ini' ? 'bg-light text-dark fw-bold' : '' }}" href="?filter=tahun_ini">Tahun Ini</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="row g-2 g-md-3 mb-2 mb-md-3">
    <div class="col-12 col-md-3">
      <div class="row g-2 g-md-3 h-100">
        <div class="col-6 col-md-12">
          <div class="card mobile-p p-3 border-0 h-100 d-flex flex-row align-items-center mobile-gap gap-3" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div class="icon-box" style="background-color: var(--color-green-300);">
              <iconify-icon icon="lucide:store" style="font-size: 24px; color: var(--color-green);"></iconify-icon>
            </div>
            <div>
              <div class="stat-title">Total UMKM</div>
              <div class="stat-value">{{ $totalUmkm }}</div>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-12">
          <div class="card mobile-p p-3 border-0 h-100 d-flex flex-row align-items-center mobile-gap gap-3" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div class="icon-box" style="background-color: var(--color-orange-200);">
              <iconify-icon icon="lucide:clipboard-list" style="font-size: 24px; color: var(--color-orange);"></iconify-icon>
            </div>
            <div>
              <div class="stat-title">Status Belum Disetujui</div>
              <div class="stat-value">{{ $totalMenunggu }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-4">
      <div class="card mobile-p p-3 border-0 h-100" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h6 class="card-title-custom text-md-start mb-2">Status UMKM</h6>
        <div class="chart-box">
          <canvas id="pieStatusUMKM"></canvas>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-5">
      <div class="card mobile-p p-3 border-0 h-100" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h6 class="card-title-custom text-md-start mb-2">Status Verifikasi Data</h6>
        <div class="chart-box">
          <canvas id="doughnutVerifikasi"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-2 g-md-3">
    <div class="col-12 col-md-8 d-flex flex-column gap-2 gap-md-3">
      <div class="card mobile-p p-3 border-0" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h6 class="card-title-custom mb-3 text-start">Jumlah UMKM tiap Kelurahan</h6>
        <div style="position: relative; height: 100%; min-height: 200px; width: 100%;">
          <canvas id="barKelurahan"></canvas>
        </div>
      </div>

      <div class="card mobile-p p-3 border-0 flex-grow-1" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h6 class="card-title-custom mb-0">Data UMKM yang Belum Disetujui</h6>
          <a href="{{ route('umkm.index') }}" style="font-size: 11px; text-decoration: underline; color: var(--color-blue); font-weight: 500;">Lihat Semua</a>
        </div>

        <div class="table-responsive">
          <table class="table table-borderless mb-0 table-mobile-text" style="font-size: 13px;">
            <tbody style="border: 1px solid var(--color-gray-200); border-radius: 8px;">
              @forelse($umkmMenunggu as $umkm)
              <tr style="border-bottom: 1px solid #E5E7EB;">
                <td class="py-2 px-2 px-md-3 text-secondary">{{ $umkm->nama }}</td>
                <td class="py-2 text-secondary">{{ $umkm->kelurahan ? $umkm->kelurahan->nama_kelurahan : '-' }}</td>
                <td class="py-2 text-secondary">{{ $umkm->kategori ? $umkm->kategori->kategori_umkm : '-' }}</td>
                <td class="py-2 text-end px-2 px-md-3">
                  <span class="badge-mobile" style="background-color: var(--color-orange-200); color: var(--color-orange); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap;">
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

    <div class="col-12 col-md-4">
      <div class="card mobile-p p-3 border-0 h-100" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h6 class="card-title-custom mb-3 text-start">Penambahan UMKM tiap Bulan</h6>
        <div style="position: relative; height: 100%; min-height: 350px; width: 100%;">
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
    Chart.defaults.scale.grid.color = '#ECECEC';

    // FUNGSI SENSOR LAYAR (Untuk Legend Pie & Doughnut)
    function updateLegendPosition(chart) {
      const isMobile = window.innerWidth <= 768;
      chart.options.plugins.legend.position = isMobile ? 'bottom' : 'right';
      chart.options.plugins.legend.labels.padding = isMobile ? 15 : 10;
      chart.options.plugins.legend.labels.boxWidth = isMobile ? 8 : 6;
      chart.options.plugins.legend.labels.font.size = isMobile ? 10 : 11;
    }

    // FUNGSI SENSOR LAYAR (Untuk Ketebalan Bar Chart)
    function updateBarThickness(chart, isHorizontal) {
      const isMobile = window.innerWidth <= 768;
      if (isHorizontal) {
        chart.data.datasets[0].barThickness = isMobile ? 6 : 8;
      } else {
        chart.data.datasets[0].barThickness = isMobile ? 20 : 30;
      }
    }

    // 1. PIE CHART
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
        onResize: function(chart) {
          updateLegendPosition(chart);
        }, // Berubah saat layar ditarik
        plugins: {
          legend: {
            position: window.innerWidth <= 768 ? 'bottom' : 'right', // Posisi awal saat diload
            labels: {
              usePointStyle: true,
              boxWidth: window.innerWidth <= 768 ? 8 : 6,
              padding: window.innerWidth <= 768 ? 15 : 10,
              font: {
                size: window.innerWidth <= 768 ? 10 : 11
              }
            }
          }
        }
      }
    });

    // 2. DOUGHNUT CHART
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
        cutout: '65%',
        onResize: function(chart) {
          updateLegendPosition(chart);
        }, // Berubah saat layar ditarik
        plugins: {
          legend: {
            position: window.innerWidth <= 768 ? 'bottom' : 'right', // Posisi awal saat diload
            labels: {
              usePointStyle: true,
              boxWidth: window.innerWidth <= 768 ? 8 : 6,
              padding: window.innerWidth <= 768 ? 15 : 10,
              font: {
                size: window.innerWidth <= 768 ? 10 : 11
              }
            }
          }
        }
      }
    });

    // 3. BAR KELURAHAN
    new Chart(document.getElementById('barKelurahan'), {
      type: 'bar',
      data: {
        labels: kelurahanLabels,
        datasets: [{
          label: 'Jumlah UMKM',
          data: kelurahanAngka,
          backgroundColor: '#41644A',
          borderRadius: 6,
          barThickness: window.innerWidth <= 768 ? 20 : 30
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        onResize: function(chart) {
          updateBarThickness(chart, false);
        },
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
              precision: 0,
              stepSize: 1
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

    // 4. BAR BULAN (HORIZONTAL)
    new Chart(document.getElementById('barBulan'), {
      type: 'bar',
      data: {
        labels: bulanLabels,
        datasets: [{
          label: 'UMKM Baru',
          data: bulanAngka,
          backgroundColor: '#1B3B6F',
          borderRadius: 6,
          barThickness: window.innerWidth <= 768 ? 6 : 8
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        onResize: function(chart) {
          updateBarThickness(chart, true);
        },
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