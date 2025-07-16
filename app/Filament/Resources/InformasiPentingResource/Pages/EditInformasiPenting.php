<?php

namespace App\Filament\Resources\InformasiPentingResource\Pages;

use App\Filament\Resources\InformasiPentingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInformasiPenting extends EditRecord
{
    protected static string $resource = InformasiPentingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
