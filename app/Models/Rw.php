<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rw extends Model
{
    protected $fillable = ['dusun_id', 'nomor_rw'];

    public function dusun()
    {
        return $this->belongsTo(Dusun::class);
    }

    public function rts()
    {
        return $this->hasMany(Rt::class);
    }
}
