<?php

namespace App\Filament\Resources\Formulas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class FormulaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')->relationship('project', 'project_name')->required(),
                TextInput::make('formula_code')
                    ->required(),
                TextInput::make('formula_status')
                    ->default(null),
                TextInput::make('target_fill_weight_mg')
                    ->numeric()
                    ->default(null),
                TextInput::make('actual_fill_weight_mg')
                    ->numeric()
                    ->default(null),
                TextInput::make('predicted_eq_ratio')
                    ->numeric()
                    ->default(null),
                TextInput::make('predicted_pH_raw')
                    ->numeric()
                    ->default(null),
                TextInput::make('compliance_pH')
                    ->numeric()
                    ->default(null),
                TextInput::make('predicted_co2_ml')
                    ->numeric()
                    ->default(null),
                TextInput::make('predicted_cost_per_unit')
                    ->numeric()
                    ->default(null),
                TextInput::make('approval_state')
                    ->default(null),
            ]);
    }
}
