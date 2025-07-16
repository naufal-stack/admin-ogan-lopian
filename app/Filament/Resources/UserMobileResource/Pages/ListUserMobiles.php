<?php

namespace App\Filament\Resources\UserMobileResource\Pages;

use App\Filament\Resources\UserMobileResource;
use Filament\Resources\Pages\ListRecords;

class ListUserMobiles extends ListRecords
{
    protected static string $resource = UserMobileResource::class;

    protected function getHeaderActions(): array
    {
        return []; // Ini menghilangkan tombol "New"
    }
}
