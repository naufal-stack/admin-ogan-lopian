<?php

namespace App\Filament\Resources\AdminResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Lapor;

class ManagementLaporChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Laporan';

    protected function getData(): array
    {
        $laporData = Lapor::select('kategori')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('kategori')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Laporan',
                    'data' => $laporData->pluck('total'),
                    'backgroundColor' => [
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                    ],
                    'borderColor' => [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $laporData->pluck('kategori'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    public function getColumnSpan(): int|string|array
    {
        return 1; // atau 1 / 2
    }
}
