<?php

namespace App\Filament\Resources\Excipients\Pages;

use App\Filament\Resources\Excipients\ExcipientResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExcipients extends ListRecords
{
    protected static string $resource = ExcipientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
