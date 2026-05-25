<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
  protected $table = 'kategori';

  public function user()
  {
    return $this->belongsTo(User::class, 'id_admin');
  }

  public function umkm()
  {
    return $this->hasMany(Umkm::class, 'id_umkm');
  }
}
