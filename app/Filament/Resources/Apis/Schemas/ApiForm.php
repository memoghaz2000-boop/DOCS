<?php

namespace App\Filament\Resources\Apis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ApiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('messages.name'))
                    ->required(),
                TextInput::make('description')
                    ->label(__('messages.description'))
                    ->default(null),
            ]);
    }
}
