<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriLoker extends Model
{

    use HasFactory, SoftDeletes; // Gunakan trait SoftDeletes

    protected $table = 'kategori_lokers'; // Pastikan nama tabel benar

    protected $fillable = [
        'name', // Hanya 'name' yang fillable karena 'total' dihitung
    ];

    /**
     * Definisikan relasi ke model Loker.
     * Sebuah KategoriLoker memiliki banyak Loker.
     */
    public function lokers()
    {
        return $this->hasMany(Loker::class, 'id_kategori');
    }
}
