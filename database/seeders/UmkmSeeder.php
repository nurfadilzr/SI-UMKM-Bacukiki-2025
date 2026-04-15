<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UmkmSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('umkm')->insert([
      [
        'nama' => 'Ayam Goreng KVC',
        'alamat' => 'Jl. Garuda',
        'kontak' => '085232312018',
        'foto' => 'uploads/umkm/ayam_kvc.jpg',
        'status_verif' => 'disetujui',
        'status_umkm' => 'aktif',
        'titik_maps' => 'https://maps.app.goo.gl/2rodWuGRVnczMuST7',
        'latitude' => -4.0167,
        'longitude' => 119.6566,
        'kelurahan_id' => 3,
        'kategori_id' => 3,
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'nama' => 'Laundry Ceria',
        'alamat' => 'Jl. Cendrawasih Blok H No. 160',
        'kontak' => '085182523118',
        'foto' => 'uploads/umkm/laundry_ceria.jpg',
        'status_verif' => 'menunggu',
        'status_umkm' => 'aktif',
        'titik_maps' => 'https://maps.app.goo.gl/sTRENL8GFwbs6Dcq6',
        'latitude' => -4.0180,
        'longitude' => 119.6589,
        'kelurahan_id' => 1,
        'kategori_id' => 1,
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ]);
  }
}
