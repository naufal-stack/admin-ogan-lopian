<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // PASTIKAN BARIS INI ADA!

class InformasiPenting extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id_user',
        'name',
        'content',
        'image',
    ];

    /**
     * Get the user that owns the important information.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
