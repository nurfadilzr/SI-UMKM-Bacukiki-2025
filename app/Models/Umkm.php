<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
  public function kelurahan()
  {
    return $this->belongsTo(Kelurahan::class);
  }

  public function kategori()
  {
    return $this->belongsTo(Kategori::class);
  }
}
