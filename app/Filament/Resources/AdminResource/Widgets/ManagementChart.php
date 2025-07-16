<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Wisata;
use App\Models\Hotel;
use App\Models\InformasiPenting;
use App\Models\Loker;
use App\Models\Sekolah;
use App\Models\Lapor;
use App\Models\Dokter;

class ManagementChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Data Management';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Data',
                    'data' => [
                        Wisata::count(),
                        Hotel::count(),
                        Loker::count(),
                        Dokter::count(),
                        InformasiPenting::count(),
                        Sekolah::count(),
                        Lapor::count()
                    ],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.7)',   // merah muda
                        'rgba(54, 162, 235, 0.7)',   // biru
                        'rgba(255, 206, 86, 0.7)',   // kuning
                        'rgba(75, 192, 192, 0.7)',   // hijau toska
                        'rgba(153, 102, 255, 0.7)',  // ungu
                        'rgba(255, 159, 64, 0.7)',   // oranye
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => [
                'Wisata',
                'Hotel',
                'Loker',
                'Dokter',
                'Informasi',
                'Sekolah',
                'Lapor'
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // bisa juga 'doughnut', 'pie', 'line', dll
    }

    public function getColumnSpan(): int|string|array
    {
        return 1; // juga setengah lebar
    }
}
