<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keterampilan extends Model
{
    protected $fillable = [
        'warga_id',
        'kategori_keterampilan_id',
        'nama_keterampilan',
        'pengalaman',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriKeterampilan::class, 'kategori_keterampilan_id');
    }
}
