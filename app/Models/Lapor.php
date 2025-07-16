<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait

class Lapor extends Model
{
    use HasFactory, SoftDeletes; // Gunakan trait SoftDeletes

    protected $table = 'lapors'; // Pastikan nama tabel benar

    protected $fillable = [
        'id_user',
        'author',
        'judul',
        'keterangan',
        'status_laporan',
        'lat',
        'lng',
        'report_time',
        'kategori',
    ];

    protected $casts = [
        'report_time' => 'datetime', // Pastikan report_time di-cast sebagai datetime
    ];
}
