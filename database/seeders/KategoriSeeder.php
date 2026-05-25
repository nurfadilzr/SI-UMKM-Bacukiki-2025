<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('kategori')->insert([
      ['kategori_umkm' => 'Jasa', 'id_admin' => 1],
      ['kategori_umkm' => 'Kerajinan', 'id_admin' => 1],
      ['kategori_umkm' => 'Kuliner', 'id_admin' => 1],
      ['kategori_umkm' => 'Retail', 'id_admin' => 1],
    ]);
  }
}
