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
            ['kategori_umkm' => 'Jasa'],
            ['kategori_umkm' => 'Kerajinan'],
            ['kategori_umkm' => 'Kuliner'],
            ['kategori_umkm' => 'Retail'],
        ]); 
    }
}
