<?php

namespace App\Filament\Resources\Apis\Pages;

use App\Filament\Resources\Apis\ApiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewApi extends ViewRecord
{
    protected static string $resource = ApiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
