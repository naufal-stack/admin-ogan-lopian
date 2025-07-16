<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class TicketController extends Controller
{
    public function sendQr(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
            'date' => 'required|date',
        ]);

        $qrCode = $request->input('qr_code');
        $date = Carbon::parse($request->input('date'))->format('Y-m-d');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer fxagusbr37f0',
        ])->post('http://192.168.33.100:4300/api/tickets/ex/save', [
            'qrCodes' => [$qrCode],
            'date' => $date,
        ]);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => $response->json(),
            ]);
        }

        return response()->json([
            'success' => false,
            'status' => $response->status(),
            'message' => $response->json('message') ?? 'Gagal mengirim QR ke server',
        ], $response->status());
    }
}
