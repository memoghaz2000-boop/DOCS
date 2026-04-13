<?php

namespace App\Filament\Resources\Experiments\Pages;

use App\Filament\Resources\Experiments\ExperimentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewExperiment extends ViewRecord
{
    protected static string $resource = ExperimentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
