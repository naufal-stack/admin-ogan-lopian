<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait

class Wisata extends Model
{
    use HasFactory, SoftDeletes; // Gunakan trait SoftDeletes

    protected $table = 'wisatas'; // Pastikan nama tabel benar

    // app/Models/Wisata.php
    protected $fillable = [
    'nama',
    'kategori',
    'deskripsi',
    'alamat',
    'website',
    'no_telp',
    'latitude',
    'longitude',
    'jam_buka',
    'jam_tutup',
    'child_price',
    'adult_price',
    'kuota', // ← Tambahkan ini
    'prioritas',
    'checkout',
    'image',
];
protected $appends = [
    'alamat',
];

public function getAlamatAttribute(): array
{
    return [
        "lat" => (float)$this->latitude,
        "lng" => (float)$this->longitude,
    ];
}

public function setAlamatAttribute(?array $location): void
{
    if (is_array($location)) {
        $this->attributes['latitude'] = $location['lat'];
        $this->attributes['longitude'] = $location['lng'];
        unset($this->attributes['alamat']);
    }
}

public static function getLatLngAttributes(): array
{
    return [
        'lat' => 'latitude',
        'lng' => 'longitude',
    ];
}

public static function getComputedLocation(): string
{
    return 'alamat';
}

}
