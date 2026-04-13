<?php

namespace App\Filament\Resources\Excipients\Pages;

use App\Filament\Resources\Excipients\ExcipientResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewExcipient extends ViewRecord
{
    protected static string $resource = ExcipientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
