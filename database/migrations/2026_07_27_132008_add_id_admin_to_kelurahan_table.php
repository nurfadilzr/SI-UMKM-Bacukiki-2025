<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Jalankan migration (Menambahkan kolom & foreign key)
   */
  public function up(): void
  {
    Schema::table('kelurahan', function (Blueprint $table) {
      // 1. Menambahkan kolom id_admin setelah kolom nama_kelurahan
      // 2. Diatur nullable() agar data lama tidak error
      // 3. constrained('users') otomatis menjadikannya foreign key ke tabel users
      $table->foreignId('id_admin')
        ->nullable()
        ->after('nama_kelurahan')
        ->constrained('users')
        ->onDelete('set null'); // Jika admin dihapus, kolom id_admin di kelurahan jadi null (aman)
    });
  }

  /**
   * Batalkan migration (Menghapus foreign key & kolom jika di-rollback)
   */
  public function down(): void
  {
    Schema::table('kelurahan', function (Blueprint $table) {
      // Wajib hapus foreign key-nya terlebih dahulu sebelum menghapus kolomnya
      $table->dropForeign(['id_admin']);
      $table->dropColumn('id_admin');
    });
  }
};
