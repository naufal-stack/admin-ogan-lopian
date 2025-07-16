<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loker extends Model
{
    //
    protected $fillable = [
        'id_user',
        'id_kategori',
        'posisi',
        'deskripsi',
        'perusahaan',
        'logo',
        'pendidikan',
        'lokasi',
        'tipe_pekerjaan',
        'level_pekerjaan',
        'kategori',
        'website',
        'salary_from',
        'salary_to',
    ];
}
