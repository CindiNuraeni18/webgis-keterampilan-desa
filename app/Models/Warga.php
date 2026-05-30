<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $fillable = [
        'rt_id',
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
    ];

    public function rt()
    {
        return $this->belongsTo(Rt::class);
    }

    public function keterampilans()
    {
    return $this->hasMany(Keterampilan::class);
    }
}
