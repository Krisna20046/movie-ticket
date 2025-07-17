<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    public function jadwals()
    {
        return $this->hasMany(\App\Models\Jadwal::class);
    }
}
