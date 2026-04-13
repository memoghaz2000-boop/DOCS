<?php

namespace App\Filament\Resources\ProductProfiles\Pages;

use App\Filament\Resources\ProductProfiles\ProductProfileResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProductProfile extends ViewRecord
{
    protected static string $resource = ProductProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
