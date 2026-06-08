<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - SI Data UMKM Kecamatan Bacukiki</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

  <style>
    :root {
      --color-green: #41644A;
      --color-green-dark: #35533C;
      --color-black: #000000;
      --color-black-800: #1A1A1A;
      --color-gray: #404040;
      --color-gray-500: #8C8C8C;
      --color-gray-700: #666666;

    }

    body {
      font-family: 'Lato', sans-serif;
      /* Background gradasi presisi dari Figma: 122 derajat, hijau tua di kiri atas */
      background: linear-gradient(122deg, #41644A 0%, #6C8773 30%, #96AA9B 60%, #ECF0ED 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      padding: 12px;
    }

    /* Styling Kartu Login */
    .login-card {
      background-color: #FFFFFF;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 420px;
      /* Ukuran maksimal di desktop */
      padding: 24px 24px;
      margin: 0 20px;
    }

    /* Logo & Judul */
    .brand-logo {
      width: 70px;
      height: auto;
      margin-bottom: 16px;
    }

    .brand-title {
      font-size: 18px;
      font-weight: 700;
      color: var(--color-black-800);
      line-height: 1.3;
      margin-bottom: 30px;
    }

    .login-subtitle {
      font-size: 13px;
      font-weight: 700;
      color: var(--color-black-800);
      margin-bottom: 2px;
      text-align: left;
    }

    .login-desc {
      font-size: 12px;
      color: var(--color-gray-700);
      margin-bottom: 24px;
      text-align: left;
      line-height: 1.3;
    }

    /* Form Input */
    .form-label-custom {
      font-size: 14px;
      font-weight: 600;
      color: var(--color-black-800);
      margin-bottom: 8px;
      display: block;
      text-align: left;
    }

    .form-control-custom {
      border-radius: 8px;
      border: 1px solid var(--color-gray-500);
      padding: 12px 16px;
      font-size: 13px;
      color: var(--color-black-800);
      width: 100%;
      transition: all 0.2s;
    }

    .form-control-custom:focus {
      border-color: var(--color-green);
      box-shadow: 0 0 0 0.2rem rgba(65, 100, 74, 0.2);
      outline: none;
    }

    .form-control-custom::placeholder {
      color: #9CA3AF;
    }

    /* Input Password dengan Mata */
    .password-container {
      position: relative;
    }

    .btn-eye {
      position: absolute;
      top: 50%;
      right: 12px;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #9CA3AF;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      padding: 4px;
      transition: color 0.2s;
    }

    .btn-eye:hover,
    .btn-eye:focus {
      color: var(--color-gray);
      outline: none;
    }

    /* Tombol Masuk */
    .btn-masuk {
      background-color: var(--color-green);
      color: #FFFFFF;
      border: none;
      border-radius: 8px;
      padding: 12px;
      font-size: 14px;
      font-weight: 700;
      width: 100%;
      transition: background-color 0.2s;
    }

    .btn-masuk:hover {
      background-color: var(--color-green-dark);
      color: #FFFFFF;
    }

    /* Footer */
    .login-footer {
      font-size: 11px;
      color: var(--color-black);
      margin-top: 30px;
      font-weight: 600;
    }

    /* Responsive Adjustments untuk HP */
    @media (max-width: 576px) {
      .login-card {
        padding: 28px 20px;
        border-radius: 16px;
      }

      .brand-title {
        font-size: 16px;
      }
    }
  </style>
</head>

<body>

  <div class="login-card text-center">

    <img src="{{ asset('images/logo_pemda.png') }}" alt="Logo Pemda" class="brand-logo">
    <div class="brand-title">
      Sistem Informasi Data UMKM<br>Kecamatan Bacukiki
    </div>

    <div class="login-subtitle">Masuk ke dashboard administrasi</div>
    <div class="login-desc">
      Digunakan untuk pengelolaan dan verifikasi data UMKM Kecamatan Bacukiki
    </div>

    @if ($errors->any())
    <div class="alert alert-danger" style="font-size: 12px; text-align: left; padding: 10px; border-radius: 8px;">
      <strong>Gagal masuk!</strong> Periksa kembali nama pengguna dan kata sandi Anda.
    </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="text-start">
      @csrf

      <div class="mb-3">
        <label for="username" class="form-label-custom">Nama Pengguna</label>
        <input type="text" id="username" name="username" class="form-control-custom" placeholder="Masukkan nama pengguna" value="{{ old('username') }}" required autofocus>
      </div>

      <div class="mb-4">
        <label for="password" class="form-label-custom">Kata Sandi</label>
        <div class="password-container">
          <input type="password" id="password" name="password" class="form-control-custom" placeholder="Masukkan kata sandi" required>
          <button type="button" class="btn-eye" id="togglePassword" tabindex="-1">
            <iconify-icon icon="lucide:eye-off" style="font-size: 18px;"></iconify-icon>
          </button>
        </div>
      </div>

      <button type="submit" class="btn-masuk">Masuk</button>
    </form>

    <div class="login-footer">
      <iconify-icon icon="lucide:copyright" style="vertical-align: -2px;"></iconify-icon> 2026 Kecamatan Bacukiki
    </div>

  </div>

  <script>
    // ==========================================
    // SCRIPT TOGGLE (LIHAT/SEMBUNYIKAN) KATA SANDI
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('password');

      togglePassword.addEventListener('click', function() {
        // Toggle tipe atribut input antara 'password' dan 'text'
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle ikon mata
        if (type === 'text') {
          this.innerHTML = '<iconify-icon icon="lucide:eye" style="font-size: 18px; color: var(--color-green);"></iconify-icon>';
        } else {
          this.innerHTML = '<iconify-icon icon="lucide:eye-off" style="font-size: 18px;"></iconify-icon>';
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>