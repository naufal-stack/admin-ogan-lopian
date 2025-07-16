<?php

namespace App\Filament\Resources\AdminResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Booking;

class ManagementVisitorChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Pengunjung Dewasa & Anak-anak';

    protected function getData(): array
    {
        $totalDewasa = Booking::sum('qty_dewasa');
        $totalAnak = Booking::sum('qty_anak');

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pengunjung',
                    'data' => [$totalDewasa, $totalAnak],
                    'backgroundColor' => [
                        'rgba(54, 162, 235, 0.7)',  // Biru: Dewasa
                        'rgba(255, 206, 86, 0.7)',  // Kuning: Anak-anak
                    ],
                    'borderColor' => [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    'borderWidth' => 1,
                ]
            ],
            'labels' => ['Dewasa', 'Anak-anak'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    public function getColumnSpan(): int|string|array
    {
        return 1; // setengah lebar
    }
}
