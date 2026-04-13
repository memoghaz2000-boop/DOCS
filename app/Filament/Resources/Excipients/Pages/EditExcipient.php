<?php

namespace App\Filament\Resources\Excipients\Pages;

use App\Filament\Resources\Excipients\ExcipientResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditExcipient extends EditRecord
{
    protected static string $resource = ExcipientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
