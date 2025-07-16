<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    //
    protected $fillable = [
        'nama',
        'kategori',
        'deskripsi',
        'image',
        'alamat',
        'website',
        'no_telp',
        'latitude',
        'longitude',
        'jam_buka',
        'jam_tutup',
    ];
}
