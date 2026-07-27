<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
  protected $table = 'kelurahan';
  protected $fillable = [
    'nama_kelurahan',
    'id_admin'
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'id_admin');
  }

  public function umkm()
  {
    return $this->hasMany(Umkm::class, 'id_kelurahan');
  }
}
