<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
  /**
   * Menampilkan halaman form login.
   */
  public function showLoginForm()
  {
    // Jika sudah login, jangan beri akses ke halaman login lagi, lempar ke dashboard
    if (Auth::check()) {
      return redirect()->route('dashboard');
    }

    // Return view login yang sudah kita buat sebelumnya
    // Diasumsikan file berada di resources/views/login.blade.php
    return view('admin.umkm.login');
  }

  /**
   * Memproses percobaan login.
   */
  public function login(Request $request)
  {
    // 1. Validasi Input dari Form
    $request->validate([
      'username' => 'required|string',
      'password' => 'required|string',
    ], [
      // Pesan error kustom bahasa indonesia
      'username.required' => 'Nama pengguna wajib diisi.',
      'password.required' => 'Kata sandi wajib diisi.',
    ]);

    // 2. Siapkan kredensial untuk dicek ke database
    // Laravel Auth secara default mencari kolom 'password' untuk di-check hash-nya.
    // Kita asumsikan di tabel 'users' Anda menggunakan kolom 'username' untuk login.
    $credentials = [
      'username' => $request->username,
      'password' => $request->password,
    ];

    // 3. Percobaan Login (Auth::attempt)
    // Fitur ini otomatis mengecek user di DB, membandingkan hash password,
    // dan membuatkan session aman jika cocok.
    if (Auth::attempt($credentials, $request->has('remember'))) {
      // LOGIN SUKSES

      // Regenerasi session ID untuk mencegah serangan Session Fixation (PENTING!)
      $request->session()->regenerate();

      // Arahkan ke halaman yang dituju sebelumnya (intended) atau ke dashboard
      return redirect()->intended(route('dashboard'))
        ->with('status', 'Selamat datang kembali, Admin!');
    }

    // 4. LOGIN GAGAL
    // Jika tidak cocok, lempar kembali ke halaman login dengan pesan error
    throw ValidationException::withMessages([
      'username' => [trans('auth.failed')], // Menggunakan pesan default Laravel: "These credentials do not match..."
    ]);
  }

  /**
   * Memproses Logout.
   */
  public function logout(Request $request)
  {
    // Hapus data autentikasi dari session
    Auth::logout();

    // Hancurkan session
    $request->session()->invalidate();

    // Regenerasi token CSRF
    $request->session()->regenerateToken();

    // Arahkan kembali ke halaman publik (beranda)
    return redirect()->route('login')
      ->with('status', 'Anda telah berhasil keluar.');
  }
}
