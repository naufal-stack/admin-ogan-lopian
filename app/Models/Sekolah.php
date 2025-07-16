<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes

class Sekolah extends Model
{
    use HasFactory, SoftDeletes; // Gunakan SoftDeletes

    protected $fillable = [
        'npsn',
        'nama',
        'alamat',
        'desa',
        'kecamatan',
        'jenjang',
        'lat',
        'lng',
    ];
}
