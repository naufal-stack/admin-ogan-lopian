<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Models\Wisata;
use App\Models\Register;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wisata_id',
        'nama_wisata',
        'pengunjung',
        'qty_anak',
        'qty_dewasa',
        'kordinat',
        'qrcode',
        'tanggal',
        'total_price',
        'status',
        'payment_status',
        'booking_code',
    ];

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            if (empty($booking->booking_code)) {
                do {
                    $booking->booking_code = 'BK-' . Str::upper(Str::random(8));
                } while (Booking::where('booking_code', $booking->booking_code)->exists());
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Register::class, 'user_id');
    }

    public function wisata(): BelongsTo
    {
        return $this->belongsTo(Wisata::class);
    }
}
