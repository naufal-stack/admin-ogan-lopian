<?php

namespace App\Filament\Resources\LokerResource\Pages;

use App\Filament\Resources\LokerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLokers extends ListRecords
{
    protected static string $resource = LokerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
