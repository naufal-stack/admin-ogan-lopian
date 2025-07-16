<?php

namespace App\Filament\Resources\AdminResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Booking;

class ManagementBookingChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Pembelian Tiket';

    protected function getData(): array
    {
        $totalPaid = Booking::where('payment_status', 'paid')->count();
        $totalUnpaid = Booking::where('payment_status', '!=', 'paid')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Status Pembayaran',
                    'data' => [$totalPaid, $totalUnpaid],
                    'backgroundColor' => [
                        'rgba(75, 192, 192, 0.7)',   // Paid - hijau toska
                        'rgba(255, 99, 132, 0.7)',   // Belum Bayar - merah muda
                    ],
                    'borderColor' => [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Lunas', 'Belum Bayar'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    public function getColumnSpan(): int|string|array
    {
        return 1; // Supaya bisa berdampingan
    }
}
