<?php

namespace App\Filament\Resources\Apis\Pages;

use App\Filament\Resources\Apis\ApiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditApi extends EditRecord
{
    protected static string $resource = ApiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
