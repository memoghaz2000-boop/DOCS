<?php

namespace App\Filament\Resources\Apis\Pages;

use App\Filament\Resources\Apis\ApiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApi extends CreateRecord
{
    protected static string $resource = ApiResource::class;
}
