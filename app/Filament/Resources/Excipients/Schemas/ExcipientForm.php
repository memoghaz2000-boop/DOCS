<?php

namespace App\Filament\Resources\Excipients\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ExcipientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('excipient_name')
                    ->required(),
                TextInput::make('category')
                    ->default(null),
                TextInput::make('mw')
                    ->numeric()
                    ->default(null),
                TextInput::make('acid_equivalents')
                    ->numeric()
                    ->default(null),
                TextInput::make('base_equivalents')
                    ->numeric()
                    ->default(null),
                TextInput::make('pKa_or_buffer_role')
                    ->default(null),
                TextInput::make('typical_lod_pct')
                    ->numeric()
                    ->default(null),
                TextInput::make('hygroscopicity_level')
                    ->default(null),
                TextInput::make('cost_per_mg')
                    ->numeric()
                    ->default(null),
                Textarea::make('compatibility_flags')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
