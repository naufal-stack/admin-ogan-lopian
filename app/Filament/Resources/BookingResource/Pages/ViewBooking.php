<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBooking extends ViewRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn () => route('admin.bookings.pdf', ['record' => $this->record->id]))
                ->openUrlInNewTab(),
        ];
    }
}
