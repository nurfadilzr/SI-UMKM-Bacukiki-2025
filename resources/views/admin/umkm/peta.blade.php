@extends('layouts.app') @section('content')

<style>
  .page-title {
    font-weight: 700;
    font-size: 22px;
    color: var(--color-black);
    margin-bottom: 24px;
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
</style>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="container-fluid">
  <h3 class="page-title">Peta Sebaran UMKM</h3>

  <div class="row">
    <div class="col-md-8">
      <div class="card" style="border-radius: 16px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 12px;">
        <div id="map" style="height: 550px; border-radius: 12px; z-index: 1;"></div>

        <div class="d-flex justify-content-center align-items-center mt-3 flex-nowrap" style="font-size: 13px; gap: 16px; white-space: nowrap; overflow-x: auto; padding-bottom: 5px;">
          <span style="font-size: 14px;">Keterangan:</span>
          <span class="d-flex align-items-center gap-1">
            <iconify-icon icon="fa-solid:map-marker-alt" style="color: var(--color-green); font-size: 18px;"></iconify-icon> UMKM Galung Maloang
          </span>
          <span class="d-flex align-items-center gap-1">
            <iconify-icon icon="fa-solid:map-marker-alt" style="color: var(--color-blue); font-size: 18px;"></iconify-icon> UMKM Lompoe
          </span>
          <span class="d-flex align-items-center gap-1">
            <iconify-icon icon="fa-solid:map-marker-alt" style="color: var(--color-orange); font-size: 18px;"></iconify-icon> UMKM Lemoe
          </span>
          <span class="d-flex align-items-center gap-1">
            <iconify-icon icon="fa-solid:map-marker-alt" style="color: var(--color-gray); font-size: 18px;"></iconify-icon> UMKM Watang Bacukiki
          </span>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-4" style="border-radius: 16px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">

        <h5 class="text-center mb-3 pb-2" style="border-bottom: 1px solid #E5E7EB; font-size: 16px;">Detail UMKM</h5>

        <div id="detail-kosong" class="text-center mt-4 mb-4 text-muted" style="font-style: italic; font-size: 14px;">
          Klik salah satu marker untuk melihat detail umkm
        </div>

        <div id="detail-isi" style="display: none; flex-direction: column;">

          <h4 id="dtl-nama" style="font-weight: 700; font-size: 22px; color: #111; margin-bottom: 14px;">Nama UMKM</h4>

          <div class="mb-4" style="display: flex; gap: 8px;">
            <span id="dtl-kategori" class="badge-kategori">Kategori</span>
            <span id="dtl-kelurahan" class="badge-kelurahan">Kelurahan</span>
          </div>

          <p class="text-dark mb-4 d-flex align-items-start gap-2" style="font-size: 15px;">
            <iconify-icon icon="fa6-solid:location-dot" style="font-size: 18px; margin-top: 3px; color: #111;"></iconify-icon>
            <span id="dtl-alamat">Alamat UMKM</span>
          </p>

          <div class="btn-group-custom">
            <a href="#" id="dtl-btn-maps" target="_blank" class="btn-card btn-maps">Maps</a>
            <a href="#" id="dtl-btn-kontak" target="_blank" class="btn-card btn-kontak">Kontak</a>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // 1. Ambil data JSON dari elemen HTML yang kita sembunyikan tadi
    // const elemenData = document.getElementById('data-penyimpanan-umkm');
    // const dataUmkm = JSON.parse(elemenData.getAttribute('data-umkms'));

    // 1. Terima data JSON dari Laravel
    const dataUmkm = @json($umkms);

    // 2. Inisialisasi Peta (Koordinat tengah Kecamatan Bacukiki)
    const map = L.map('map').setView([-4.0200, 119.6500], 13);

    // 3. Pasang Tile Layer (Peta Dasarnya dari OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Variabel untuk menyimpan marker yang sedang dipilih
    let selectedMarker = null;
    // Variabel untuk menyimpan semua marker
    let allMarkers = [];

    // 4. Fungsi Pembuat Marker Dinamis dengan Parameter Ukuran (kecil / besar)
    function getMarkerIcon(namaKelurahan, size = 'small') {
      let pinColor = "#404040"; // Default Hitam (Watang Bacukiki)

      // Sesuaikan nama string ini dengan nama asli kelurahan di database Anda!
      if (namaKelurahan.includes('Galung Maloang')) pinColor = "#41644A"; // Hijau
      else if (namaKelurahan.includes('Lompoe')) pinColor = "#1B3B6F"; // Biru Gelap
      else if (namaKelurahan.includes('Lemoe')) pinColor = "#D17A22"; // Oranye

      // Tentukan ukuran SVG dan Anchor berdasarkan parameter size
      let svgWidth, svgHeight, iconWidth, iconHeight, anchorX, anchorY;

      if (size === 'small') {
        svgWidth = 20;
        svgHeight = 28;
        iconWidth = 20;
        iconHeight = 28;
        anchorX = 11;
        anchorY = 31;
      } else { // 'large'
        svgWidth = 30;
        svgHeight = 42;
        iconWidth = 30;
        iconHeight = 42;
        anchorX = 15;
        anchorY = 42;
      }

      const svgIcon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="${svgWidth}" height="${svgHeight}"><path fill="${pinColor}" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>`;

      return L.divIcon({
        html: svgIcon,
        className: '',
        iconSize: [iconWidth, iconHeight],
        iconAnchor: [anchorX, anchorY] // Titik tumpu pin agar pas di koordinat
      });
    }

    // Fungsi untuk mereset ukuran semua marker menjadi kecil
    function resetMarkerSizes() {
      allMarkers.forEach(item => {
        const smallIcon = getMarkerIcon(item.kelurahan, 'small');
        item.marker.setIcon(smallIcon);
      });
    }

    // 5. Looping Data UMKM untuk Ditaruh di Peta
    dataUmkm.forEach(umkm => {
      const lat = parseFloat(umkm.latitude);
      const lng = parseFloat(umkm.longitude);
      const namaKelurahan = umkm.kelurahan ? umkm.kelurahan.nama_kelurahan : '';

      // Lewati jika koordinat tidak valid (NaN)
      if (isNaN(lat) || isNaN(lng)) return;

      // Buat Marker (Secara default berukuran KECIL)
      const marker = L.marker([lat, lng], {
        icon: getMarkerIcon(namaKelurahan, 'small')
      }).addTo(map);

      // Simpan marker dan kelurahan ke dalam array
      allMarkers.push({
        marker: marker,
        kelurahan: namaKelurahan
      });

      // 6. EVENT LISTENER: Apa yang terjadi saat Marker diklik?
      marker.on('click', function() {

        // --- Logika Resizing Marker ---
        // 1. Reset semua marker lain menjadi kecil
        resetMarkerSizes();
        // 2. Ubah marker yang diklik menjadi BESAR
        const largeIcon = getMarkerIcon(namaKelurahan, 'large');
        marker.setIcon(largeIcon);
        // Simpan marker yang sedang dipilih
        selectedMarker = marker;

        // --- Sisa kode untuk menampilkan detail di sidebar (TETAP SAMA) ---

        // Sembunyikan teks default, Munculkan isi detail
        document.getElementById('detail-kosong').style.display = 'none';
        document.getElementById('detail-isi').style.display = 'flex';

        // Ganti isi teks HTML
        document.getElementById('dtl-nama').innerText = umkm.nama;
        document.getElementById('dtl-alamat').innerText = umkm.alamat;

        // Ganti Badge
        document.getElementById('dtl-kategori').innerText = umkm.kategori ? umkm.kategori.kategori_umkm : '-';
        document.getElementById('dtl-kelurahan').innerText = namaKelurahan || '-';

        // Ganti Link Tombol
        document.getElementById('dtl-btn-maps').href = umkm.titik_maps || `https://www.google.com/maps/search/?api=1&query=${lat},${lng}`;
        document.getElementById('dtl-btn-kontak').href = umkm.kontak ? `https://wa.me/${umkm.kontak}` : '#';
      });
    });
  });
</script>

@endsection