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

  <link rel="shortcut icon" href="{{ asset('images/logo_pemda.png') }}" type=image/jpg>

  <style>
    /* === DESIGN TOKENS (COLOR STYLES) === */
    :root {
      --color-green: #41644A;
      --color-orange: #D17A22;
      --color-blue: #1B3B6F;
      --color-gray: #404040;
      --color-black: #000000;

      --color-green-50: #ECEFED;
      --color-green-100: #D9E0DB;
      --color-green-300: #B3C1B7;
      --color-green-800: #54745C;

      --color-orange-50: #FAF2E9;
      --color-orange-100: #F6E4D3;
      --color-orange-200: #F1D7BD;

      --color-blue-200: #BBC4D4;
      --color-blue-600: #5F769A;
      --color-blue-700: #49628C;

      --color-gray-light: #F3F4F6;
      --color-gray-50: #ECECEC;
      --color-gray-200: #C6C6C6;
      --color-gray-500: #8C8C8C;
      --color-gray-600: #797979;
      --color-gray-700: #666666;

      --color-black-50: #E6E6E6;
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

    /* Menyembunyikan sidebar di layar HP (< 768px) */
    @media (max-width: 767px) {
      .admin-sidebar-desktop {
        display: none !important;
      }
    }

    /* CSS Khusus Mobile Menu List */
    .mobile-menu-list li a {
      display: block;
      padding: 10px 0;
      color: var(--color-black);
      font-size: 16px;
      font-weight: 600;
      text-decoration: none;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      color: var(--color-black);
    }

    /*===STYLING SIDEBAR (Disesuaikan ke 90%)===*/
    .sidebar {
      width: 180px;
      background-color: #ffffff;
      border-right: 1px solid var(--color-gray-50);
      display: flex;
      flex-direction: column;
      position: sticky;
      min-height: 100vh;
      flex: 1;
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
      line-height: 1.2;
      margin-bottom: -6px;
    }

    .sidebar-subtitle {
      color: var(--color-gray);
      font-size: 11px;
      font-weight: 400;
      line-height: 1.0;
    }

    .nav-menu {
      padding: 0 14px;
      flex-grow: 1;
    }

    .nav-link-custom {
      color: var(--color-green);
      padding: 8px 10px;
      border-radius: 5px;
      margin-bottom: 6px;
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      font-weight: 500;
      font-size: 12px;
      transition: all 0.2s ease-in-out;
    }

    .nav-link-custom iconify-icon {
      font-size: 18px;
    }

    .nav-link-custom:hover {
      background-color: var(--color-green-100);
      color: var(--color-green);
    }

    .nav-link-custom.active {
      background-color: var(--color-green);
      color: white;
      font-weight: 600;
    }

    .sidebar-footer {
      padding: 12px 14px;
      border-top: 2px solid var(--color-gray-50);
      margin-top: auto;
    }

    .btn-book {
      color: var(--color-blue);
    }

    .btn-keluar {
      color: var(--color-orange);
    }

    .btn-book:hover {
      background-color: var(--color-blue-200);
      color: var(--color-blue);
    }

    .btn-keluar:hover {
      background-color: var(--color-orange-100);
      color: var(--color-orange);
    }

    .main-content {
      margin-left: 180px;
      flex-grow: 1;
      padding: 24px 28px;
      width: calc(100% - 180px);
    }
  </style>
</head>

<body>
  <div class="d-flex min-vh-100 w-100">
    <aside class="admin-sidebar-desktop flex-shrink-0 d-none d-md-flex flex-column bg-white shadow-sm" style="width: 180px; height: 100vh; position: sticky; top: 0; align-self: flex-start; overflow-y: auto;">
      <div class="sidebar-header">
        <img src="{{ asset('images/logo_pemda.png') }}" alt="Logo">
        <div>
          <p class="sidebar-title">SI Data UMKM</p>
          <span class="sidebar-subtitle">Kecamatan Bacukiki</span>
        </div>
      </div>
      <nav class="nav-menu">
        <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
          <iconify-icon icon="lucide:layout-dashboard"></iconify-icon> Dashboard
        </a>
        <a href="{{ route('umkm.daftar') }}" class="nav-link-custom {{ request()->routeIs('umkm.daftar') ? 'active' : '' }}">
          <iconify-icon icon="lucide:list"></iconify-icon> Daftar UMKM
        </a>
        <a href="{{ route('umkm.index') }}" class="nav-link-custom {{ request()->routeIs('umkm.index', 'umkm.edit', 'umkm.verifikasi', 'umkm.create', 'umkm.import.form') ? 'active' : '' }}">
          <iconify-icon icon="lucide:shield-check"></iconify-icon> Verifikasi Data
        </a>
        <a href="{{ route('umkm.peta') }}" class="nav-link-custom {{ request()->routeIs('umkm.peta') ? 'active' : '' }}">
          <iconify-icon icon="lucide:map-pin"></iconify-icon> Peta Sebaran
        </a>
        <a href="{{ route('kategori.index') }}" class="nav-link-custom {{ request()->routeIs('kategori.index') ? 'active' : '' }}">
          <iconify-icon icon="lucide:tags"></iconify-icon> Tambah Kategori
        </a>
        <a href="{{ route('kelurahan.index') }}" class="nav-link-custom {{ request()->routeIs('kelurahan.index') ? 'active' : '' }}">
          <iconify-icon icon="lucide:map-plus"></iconify-icon> Tambah Kelurahan
        </a>
      </nav>

      <div class="sidebar-footer">
        <a href="https://docs.google.com/document/d/1JmJYP7vHWA6wmZHJ9xqZ2lJ_ZzdvJuNGbdQ9m4TZb0o/edit?usp=sharing" target="_blank" class="nav-link-custom btn-book">
          <iconify-icon icon="lucide:book-open"></iconify-icon> Manual Book
        </a>
        <a href="{{ route('logout') }}" class="nav-link-custom btn-keluar">
          <iconify-icon icon="lucide:log-out"></iconify-icon> Keluar
        </a>
      </div>

    </aside>

    <div class="flex-grow-1 d-flex flex-column" style="min-width: 0; overflow-x: hidden;">

      <!-- navbar mobile -->
      <nav class="d-md-none d-flex justify-content-between align-items-center bg-white shadow-sm px-4 py-3 sticky-top">
        <div class="d-flex align-items-center">
          <img src="{{ asset('images/logo_pemda.png') }}" alt="Logo" height="35" class="me-2">
          <div>
            <div style="font-weight: 700; font-size: 15px; line-height: 1; color: var(--color-black);">SI Data UMKM</div>
            <div style="font-size: 11px; color: var(--color-gray);">Kecamatan Bacukiki</div>
          </div>
        </div>

        <button class="btn border-0 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileAdminMenu">
          <iconify-icon icon="lucide:menu" style="font-size: 28px; color: var(--color-gray);"></iconify-icon>
        </button>
      </nav>

      <main>
        @yield('content')
      </main>

    </div>
  </div>

  <div class="offcanvas offcanvas-top" tabindex="-1" id="mobileAdminMenu" style="background-color: #FFFFFF; height: auto !important; bottom: auto !important; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; box-shadow: 0 12px 30px rgba(0,0,0,0.15) !important;">

    <div class="offcanvas-header px-4 pt-4 pb-2">
      <div class="d-flex align-items-center">
        <img src="{{ asset('images/logo_pemda.png') }}" alt="Logo" height="35" class="me-2">
        <div>
          <div style="font-weight: 700; font-size: 15px; line-height: 1; color: var(--color-black);">SI Data UMKM</div>
          <div style="font-size: 11px; color: var(--color-gray);">Kecamatan Bacukiki</div>
        </div>
      </div>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close" style="font-size: 16px;"></button>
    </div>

    <div class="offcanvas-body px-4 pb-4 pt-1">

      <ul class="list-unstyled mobile-menu-list mb-3">
        <li class="mb-3"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="mb-3"><a href="{{ route('umkm.daftar') }}">Daftar UMKM</a></li>
        <li class="mb-3"><a href="{{ route('umkm.index') }}">Verifikasi Data</a></li>
        <li class="mb-3"><a href="{{ route('umkm.peta') }}">Peta Sebaran</a></li>
        <li class="mb-3"><a href="{{ route('kategori.index') }}">Tambah Kategori</a></li>
        <li class="mb-2"><a href="{{ route('kelurahan.index') }}">Tambah Kelurahan</a></li>
      </ul>

      <div class="mt-2">
        <a href="https://docs.google.com/document/d/1JmJYP7vHWA6wmZHJ9xqZ2lJ_ZzdvJuNGbdQ9m4TZb0o/edit?usp=sharing" target="_blank" class="btn w-100 text-white mb-3 py-2" style="background-color: var(--color-blue); font-weight: 600; border-radius: 8px;">
          Manual Book
        </a>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn w-100 text-white py-2" style="background-color: var(--color-orange); font-weight: 600; border-radius: 8px;">
            Keluar
          </button>
        </form>
      </div>

    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>