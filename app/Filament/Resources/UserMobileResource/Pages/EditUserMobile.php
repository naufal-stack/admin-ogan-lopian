<?php

namespace App\Filament\Resources\UserMobileResource\Pages;

use App\Filament\Resources\UserMobileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserMobile extends EditRecord
{
    protected static string $resource = UserMobileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
