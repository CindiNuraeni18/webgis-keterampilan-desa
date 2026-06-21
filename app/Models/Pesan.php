<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $fillable = [
    'nama',
    'nik',
    'nomor_hp',
    'dusun',
    'rw',
    'rt',
    'kategori_keterampilan_id',
    'keterampilan',
    'pesan',
    'status',
    'status_baca',
    'alasan_penolakan'
    ];
    public function kategori()
{
    return $this->belongsTo(
        KategoriKeterampilan::class,
        'kategori_keterampilan_id'
    );
}
}