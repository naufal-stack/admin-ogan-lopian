<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingPdfController extends Controller
{
    public function show($id)
    {
        $booking = Booking::with('wisata')->findOrFail($id);

        if ($booking->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Akses ditolak.',
            ], 403);
        }

        $pdf = Pdf::loadView('pdf.tiket', compact('booking'));

        return $pdf->stream('tiket-' . $booking->booking_code . '.pdf');
    }
}
