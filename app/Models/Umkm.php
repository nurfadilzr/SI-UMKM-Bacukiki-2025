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
    'status_umkm',
    'catatan_penolakan',
    'latitude',
    'longitude',
    'spreadsheet_row_id',
    'id_admin',
    'id_kelurahan',
    'id_kategori'
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'id_admin');
  }

  public function kelurahan()
  {
    return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
  }

  public function kategori()
  {
    return $this->belongsTo(Kategori::class, 'id_kategori');
  }
}
