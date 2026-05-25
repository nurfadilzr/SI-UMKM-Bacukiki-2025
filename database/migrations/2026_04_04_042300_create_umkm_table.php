<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('umkm', function (Blueprint $table) {
      $table->id();
      $table->string('nama', 255);
      $table->string('alamat', 255);   // ganti varchar
      $table->string('titik_maps', 255);
      $table->string('kontak', 20);
      $table->string('foto', 255);

      $table->decimal('latitude', 8, 6)->nullable();   // (8,6) - 8 digit, 6 blkng koma
      $table->decimal('longitude', 9, 6)->nullable();  // (9,6) - 9 digit, 6 blkng koma
      $table->index(['latitude', 'longitude']);

      $table->string('spreadsheet_row_id')->unique()->nullable();

      $table->enum('status_verif', ['disetujui', 'menunggu', 'ditolak'])->default('menunggu');
      $table->enum('status_umkm', ['aktif', 'tidak'])->default('aktif');
      $table->string('catatan_penolakan', 255)->nullable();

      $table->foreignId('id_admin')->constrained('users')->cascadeOnDelete();
      $table->foreignId('id_kategori')->constrained('kategori')->cascadeOnDelete();
      $table->foreignId('id_kelurahan')->constrained('kelurahan')->cascadeOnDelete();
      $table->index('id_kelurahan');
      $table->index('id_kategori');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('umkm');
  }
};
