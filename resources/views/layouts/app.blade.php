<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SI Data UMKM - Kecamatan Bacukiki</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;500;600;700&display=swap" rel="stylesheet">

  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

  <style>
    /* === DESIGN TOKENS (COLOR STYLES) === */
    :root {
      /* 5 Warna Utama (Base = 500) */
      --color-green: #41644A;
      --color-blue: #1B3B6F;
      --color-orange: #D17A22;
      --color-black: #000000;
      --color-gray: #404040;

      /* Turunan Warna (Opacity/Lightness untuk Background Badge dll) */
      --color-green-light: rgba(65, 100, 74, 0.15);
      --color-green-800: #54745C;
      /* Untuk badge disetujui */
      --color-orange-light: rgba(209, 122, 34, 0.15);
      --color-blue-light: #BBC4D4;
      --color-blue-600: #5F769A;
      --color-blue-700: #49628C;
      --color-blue-200: #BBC4D4;

      /* blue 200 */
      --color-gray-light: #F3F4F6;
      --color-gray-50: #ECECEC;
      /* Untuk badge menunggu / Background */
      --color-gray-500: #8C8C8C;
      --color-gray-600: #797979;
      --color-gray-700: #666666;

      /* grey 500 */
      --color-bg-main: #FAFAFA;
      /* Background Konten Utama */
      --color-border: #E5E7EB;
      /* Border Color */
    }

    /* === GLOBAL TYPOGRAPHY === */
    body {
      font-family: 'Lato', sans-serif;
      background-color: var(--color-gray-light);
      color: var(--color-gray);
      display: flex;
      min-height: 100vh;
      margin: 0;
      font-weight: 400;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      color: var(--color-black);
    }

    /* === STYLING SIDEBAR (Disesuaikan ke 90%) === */
    .sidebar {
      width: 180px;
      /* Diperkecil dari 200px */
      background-color: #ffffff;
      border-right: 1px solid var(--color-border);
      display: flex;
      flex-direction: column;
      position: fixed;
      height: 100vh;
    }

    .sidebar-header {
      padding: 24px 14px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .sidebar-header img {
      width: 38px;
    }

    .sidebar-title {
      color: var(--color-black);
      font-weight: 700;
      font-size: 13px;
      /* Diperkecil dari 14px */
      line-height: 1.2;
      margin-bottom: -6px;
    }

    .sidebar-subtitle {
      color: var(--color-gray);
      font-size: 11px;
      /* Diperkecil dari 12px */
      font-weight: 400;
    }

    .nav-menu {
      padding: 0 14px;
      flex-grow: 1;
    }

    .nav-link-custom {
      color: var(--color-green);
      padding: 8px 10px;
      /* Padding menu dirapatkan */
      border-radius: 5px;
      margin-bottom: 6px;
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      font-weight: 500;
      font-size: 12px;
      /* Diperkecil dari 13px */
      transition: all 0.2s ease-in-out;
    }

    .nav-link-custom iconify-icon {
      font-size: 18px;
      /* Ikon diperkecil dari 20px */
    }

    .nav-link-custom:hover {
      background-color: var(--color-green-light);
      color: var(--color-green);
    }

    .nav-link-custom.active {
      background-color: var(--color-green);
      color: white;
      font-weight: 600;
    }

    .sidebar-footer {
      padding: 12px 14px;
      border-top: 2px solid var(--color-border);
    }

    .btn-book {
      color: var(--color-blue);
    }

    .btn-keluar {
      color: var(--color-orange);
    }

    .btn-book:hover {
      background-color: var(--color-blue-light);
      color: var(--color-blue);
    }

    .btn-keluar:hover {
      background-color: var(--color-orange-light);
      color: var(--color-orange);
    }

    /* === STYLING KONTEN UTAMA (Disesuaikan ke 90%) === */
    .main-content {
      margin-left: 180px;
      /* Mengikuti lebar sidebar baru */
      flex-grow: 1;
      padding: 24px 28px;
      /* Padding dikurangi sedikit agar lebih padat */
      width: calc(100% - 180px);
      /* Mengikuti lebar sidebar baru */
    }
  </style>
</head>

<body>

  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="{{ asset('images/logo_pemda.png') }}" alt="Logo">
      <div>
        <p class="sidebar-title">SI Data UMKM</p>
        <span class="sidebar-subtitle">Kecamatan Bacukiki</span>
      </div>
    </div>

    <nav class="nav-menu">
      <a href="#" class="nav-link-custom"><iconify-icon icon="lucide:layout-dashboard"></iconify-icon> Dashboard</a>
      <a href="#" class="nav-link-custom"><iconify-icon icon="lucide:list"></iconify-icon> Daftar UMKM</a>
      <a href="{{ route('umkm.index') }}" class="nav-link-custom active"><iconify-icon icon="lucide:shield-check"></iconify-icon> Verifikasi Data</a>
      <a href="#" class="nav-link-custom"><iconify-icon icon="lucide:map-pin"></iconify-icon> Peta Sebaran</a>
      <a href="#" class="nav-link-custom"><iconify-icon icon="lucide:tags"></iconify-icon> Tambah Kategori</a>
    </nav>

    <div class="sidebar-footer">
      <a href="#" class="nav-link-custom btn-book"><iconify-icon icon="lucide:book-open"></iconify-icon> Manual Book</a>
      <a href="#" class="nav-link-custom btn-keluar"><iconify-icon icon="lucide:log-out"></iconify-icon> Keluar</a>
    </div>
  </aside>

  <main class="main-content">
    @yield('content')
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>