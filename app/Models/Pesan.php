<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $fillable = [
    'nama',
    'email',
    'nomor_hp',
    'dusun',
    'rw',
    'rt',
    'keterampilan',
    'pesan',
    'status',
    'status_baca',
    'alasan_penolakan'
    ];
}