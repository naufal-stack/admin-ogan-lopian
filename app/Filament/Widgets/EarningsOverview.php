<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Booking;
use Carbon\Carbon;

class EarningsOverview extends BaseWidget
{
    protected ?string $heading = 'Ringkasan Pendapatan Tiket';

    protected function getCards(): array
    {
        return [
            // Hari ini
            Card::make('Uang Masuk Hari Ini',
                'Rp ' . number_format(
                    Booking::where('payment_status', 'paid')
                        ->whereBetween('updated_at', [
                            Carbon::today(), // 00:00 hari ini
                            Carbon::today()->endOfDay() // 23:59:59 hari ini
                        ])
                        ->sum('total_price'),
                    0, ',', '.'
                )
            )->icon('heroicon-o-calendar')
             ->color('success'),

            // Kemarin
            Card::make('Uang Masuk Kemarin',
                'Rp ' . number_format(
                    Booking::where('payment_status', 'paid')
                        ->whereBetween('updated_at', [
                            Carbon::yesterday(),
                            Carbon::yesterday()->endOfDay()
                        ])
                        ->sum('total_price'),
                    0, ',', '.'
                )
            )->icon('heroicon-o-calendar-days')
             ->color('warning'),

            // Bulan ini
            Card::make('Uang Masuk Bulan Ini',
                'Rp ' . number_format(
                    Booking::where('payment_status', 'paid')
                        ->whereYear('updated_at', now()->year)
                        ->whereMonth('updated_at', now()->month)
                        ->sum('total_price'),
                    0, ',', '.'
                )
            )->icon('heroicon-o-chart-bar')
             ->color('info'),

            // Bulan lalu
            Card::make('Uang Masuk Bulan Lalu',
                'Rp ' . number_format(
                    Booking::where('payment_status', 'paid')
                        ->whereYear('updated_at', now()->subMonth()->year)
                        ->whereMonth('updated_at', now()->subMonth()->month)
                        ->sum('total_price'),
                    0, ',', '.'
                )
            )->icon('heroicon-o-archive-box')
             ->color('gray'),
        ];
    }
}
