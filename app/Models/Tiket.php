<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $fillable = [
        'pemesanan_id',
        'jadwal_id',
        'kursi_id',
        'harga',
    ];
}
