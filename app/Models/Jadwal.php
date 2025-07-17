<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    public function studio()
    {
        return $this->belongsTo(\App\Models\Studio::class);
    }

    public function film()
    {
        return $this->belongsTo(\App\Models\Film::class);
    }
}
