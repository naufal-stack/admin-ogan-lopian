<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Booking;


class Register extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $table = 'registers';

    protected $fillable = [
        'username',
        'email',
        'nama_lengkap',
        'nik_ktp',
        'telepon',
        'tgl_lahir',
        'password',
        'activation_key',
        'verified_at',
        'role', // Tambahkan role
    ];

    protected $hidden = [
        'password',
        'activation_key',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'verified_at' => 'datetime',
        'tgl_lahir' => 'date',
    ];
    public function bookings()
{
    return $this->hasMany(Booking::class, 'user_id');
}

}
