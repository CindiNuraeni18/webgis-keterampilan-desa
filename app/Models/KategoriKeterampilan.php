<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKeterampilan extends Model
{
     protected $fillable = ['nama_kategori'];

    public function keterampilans()
    {
        return $this->hasMany(Keterampilan::class);
    }
}
