<?php

namespace App\Filament\Resources\Apis\Pages;

use App\Filament\Resources\Apis\ApiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListApis extends ListRecords
{
    protected static string $resource = ApiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
