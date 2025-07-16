<?php

namespace App\Filament\Resources\InformasiPentingResource\Pages;

use App\Filament\Resources\InformasiPentingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInformasiPentings extends ListRecords
{
    protected static string $resource = InformasiPentingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
