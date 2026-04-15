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
      ['nama_kelurahan' => 'Galung Maloang'],
      ['nama_kelurahan' => 'Lemoe'],
      ['nama_kelurahan' => 'Lompoe'],
      ['nama_kelurahan' => 'Watang Bacukiki'],
    ]);
  }
}
