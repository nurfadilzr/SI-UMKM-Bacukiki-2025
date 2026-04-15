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
      $table->string('nama', 150);
      $table->text('alamat');
      $table->string('titik_maps', 255);
      $table->string('kontak', 20);
      $table->string('foto', 255);

      $table->enum('status_verif', ['disetujui', 'menunggu', 'ditolak'])->default('menunggu');
      $table->enum('status_umkm', ['aktif', 'tidak'])->default('aktif');

      $table->decimal('latitude', 10, 7)->nullable();
      $table->decimal('longitude', 10, 7)->nullable();
      $table->index(['latitude', 'longitude']);

      $table->string('spreadsheet_row_id')->unique()->nullable();

      $table->foreignId('kelurahan_id')->constrained('kelurahan')->cascadeOnDelete();
      $table->foreignId('kategori_id')->constrained('kategori')->cascadeOnDelete();
      $table->index('kelurahan_id');
      $table->index('kategori_id');

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
