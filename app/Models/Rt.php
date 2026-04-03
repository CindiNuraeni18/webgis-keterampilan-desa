<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    protected $fillable = ['rw_id', 'nomor_rt'];

    public function rw()
    {
        return $this->belongsTo(Rw::class);
    }

    public function wargas()
    {
        return $this->hasMany(Warga::class);
    }
}
