<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Wisata;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar pemesanan pengguna yang sedang login.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $bookings = $request->user()
                ->bookings()
                ->with('wisata')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Daftar pemesanan berhasil diambil.',
                'data' => $bookings,
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil daftar pemesanan: ' . $e->getMessage(), [
                'user_id' => $request->user()?->id,
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil daftar pemesanan.',
            ], 500);
        }
    }

    /**
     * Menyimpan pemesanan baru.
     */
    public function store(StoreBookingRequest $request): JsonResponse
{
    DB::beginTransaction();

    try {
        $wisata = Wisata::lockForUpdate()->find($request->wisata_id);

        if (!$wisata) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Wisata tidak ditemukan.',
            ], 404);
        }

        $totalTiket = $request->qty_anak + $request->qty_dewasa;

        if ($wisata->kuota < $totalTiket) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Kuota tidak mencukupi.',
            ], 422);
        }

        $totalHarga = ($wisata->child_price * $request->qty_anak) +
                      ($wisata->adult_price * $request->qty_dewasa);

        $wisata->kuota -= $totalTiket;
        $wisata->save();

        $booking = Booking::create([
            'user_id'        => $request->user()->id,
            'wisata_id'      => $wisata->id,
            'nama_wisata'    => $wisata->nama ?? '-',
            'pengunjung'     => $request->user()->nama_lengkap ?? '-',
            'qty_anak'       => $request->qty_anak,
            'qty_dewasa'     => $request->qty_dewasa,
            'kordinat'       => '-',
            'qrcode'         => '-',
            'tanggal'        => $request->tanggal,
            'total_price'    => $totalHarga,
            'status'         => 'pending',
            'payment_status' => 'unpaid',
        ]);

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Pemesanan berhasil dibuat.',
            'data' => $booking->load('wisata'),
        ], 201);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Gagal membuat pemesanan: ' . $e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan saat membuat pemesanan.',
        ], 500);
    }
}


    /**
     * Menampilkan detail pemesanan.
     */
    public function show(Booking $booking): JsonResponse
    {
        if ($booking->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Anda tidak memiliki akses.',
            ], 403);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail pemesanan berhasil diambil.',
            'data' => $booking->load('wisata'),
        ]);
    }

    /**
     * Membatalkan pemesanan.
     */
    public function cancel(Booking $booking): JsonResponse
    {
        if ($booking->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Akses ditolak.',
            ], 403);
        }

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return response()->json([
                'status' => false,
                'message' => 'Pemesanan tidak bisa dibatalkan karena status sudah ' . $booking->status,
            ], 400);
        }

        DB::beginTransaction();

        try {
            $wisata = Wisata::lockForUpdate()->find($booking->wisata_id);

            if ($wisata) {
                $wisata->kuota += $booking->qty_anak + $booking->qty_dewasa;
                $wisata->save();
            }

            $booking->update(['status' => 'cancelled']);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Pemesanan berhasil dibatalkan.',
                'data' => $booking->load('wisata'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal membatalkan pemesanan: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat membatalkan.',
            ], 500);
        }
    }

    /**
 * Konfirmasi pembayaran (ubah status menjadi confirmed & paid).
 */
public function confirm(Booking $booking): JsonResponse
{
    if ($booking->user_id !== auth()->id()) {
        return response()->json([
            'status' => false,
            'message' => 'Akses ditolak.',
        ], 403);
    }

    if ($booking->status !== 'pending') {
        return response()->json([
            'status' => false,
            'message' => 'Hanya pemesanan dengan status pending yang bisa dikonfirmasi.',
        ], 400);
    }

    $booking->update([
        'status' => 'confirmed',
        'payment_status' => 'paid',
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Pemesanan berhasil dikonfirmasi.',
        'data' => $booking->load('wisata'),
    ]);
}

}
