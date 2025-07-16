<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Wisata;
use App\Models\Hotel;
use App\Models\InformasiPenting;
use App\Models\Loker;
use App\Models\Sekolah;
use App\Models\Dokter;
use App\Models\TransaksiTiketWisata;
use Filament\Support\Colors\Color; // optional
use App\Models\Booking;
use Carbon\Carbon;

class ManagementOverview extends BaseWidget
{

    protected ?string $heading = 'Ringkasan Data';

    protected function getCards(): array
    {
        return [
            Card::make('Wisata', Wisata::count())
                ->icon('heroicon-o-map')
                ->color('success'),

            Card::make('Hotel', Hotel::count())
                ->icon('heroicon-o-building-office')
                ->color('primary'),

            Card::make('Loker', Loker::count())
                ->icon('heroicon-o-briefcase')
                ->color('info'),

            Card::make('Sekolah', Sekolah::count())
                ->icon('heroicon-o-academic-cap')
                ->color('warning'),

            Card::make('Dokter', Dokter::count())
                ->icon('heroicon-o-user-group')
                ->color('danger'),

            Card::make('Informasi Penting', InformasiPenting::count())
                ->icon('heroicon-o-exclamation-circle')
                ->color('gray'),

        ];
    }
}
