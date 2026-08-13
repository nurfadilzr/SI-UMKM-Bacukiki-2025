<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelurahanSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('kelurahan')->insert([
      ['nama_kelurahan' => 'Galung Maloang', 'id_admin' => 1],
      ['nama_kelurahan' => 'Lemoe', 'id_admin' => 1],
      ['nama_kelurahan' => 'Lompoe', 'id_admin' => 1],
      ['nama_kelurahan' => 'Watang Bacukiki', 'id_admin' => 1],
    ]);
  }
}
