<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
  protected $table = 'umkm';
  protected $fillable = [
    'nama',
    'alamat',
    'titik_maps',
    'kontak',
    'foto',
    'status_verif',
    'status_aktif',
    'latitude',
    'longitude',
    'spreadsheet_row_id', // <- Jangan lupa masukkan ini
    'kelurahan_id',
    'kategori_id'
  ];

  public function kelurahan()
  {
    return $this->belongsTo(Kelurahan::class);
  }

  public function kategori()
  {
    return $this->belongsTo(Kategori::class);
  }
}
