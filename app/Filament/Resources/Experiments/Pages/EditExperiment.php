<?php

namespace App\Filament\Resources\Experiments\Pages;

use App\Filament\Resources\Experiments\ExperimentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditExperiment extends EditRecord
{
    protected static string $resource = ExperimentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
