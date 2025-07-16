<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes

class Dokter extends Model
{
    use HasFactory, SoftDeletes; // Gunakan SoftDeletes

    protected $fillable = [
        'id_user',
        'nomor_str',
        'nama',
        'username',
        'password',
        'keahlian',
        'handphone',
        'unit_kerja',
        'pengalaman',
        'foto',
        'device_token',
        'last_update',
    ];

    // Sembunyikan password saat di-serialize ke JSON
    protected $hidden = [
        'password',
    ];

    /**
     * Get the user that owns the Dokter.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
