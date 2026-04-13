<?php

namespace App\Filament\Resources\ProductProfiles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ProductProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')->relationship('project', 'project_name')->required(),
                TextInput::make('strength_mg')
                    ->numeric()
                    ->default(null),
                TextInput::make('fill_weight_target_mg')
                    ->numeric()
                    ->default(null),
                TextInput::make('target_effervescence_sec')
                    ->numeric()
                    ->default(null),
                TextInput::make('target_pH')
                    ->numeric()
                    ->default(null),
                TextInput::make('pH_low')
                    ->numeric()
                    ->default(null),
                TextInput::make('pH_high')
                    ->numeric()
                    ->default(null),
                TextInput::make('target_f2_min')
                    ->numeric()
                    ->default(null),
                TextInput::make('max_moisture_pct')
                    ->numeric()
                    ->default(null),
                TextInput::make('max_cu_rsd_pct')
                    ->numeric()
                    ->default(null),
                TextInput::make('rh_limit_pct')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
