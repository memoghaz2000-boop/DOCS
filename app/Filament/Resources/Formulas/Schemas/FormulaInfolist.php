<?php

namespace App\Filament\Resources\Formulas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FormulaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('project_id')
                    ->numeric(),
                TextEntry::make('formula_code'),
                TextEntry::make('formula_status')
                    ->placeholder('-'),
                TextEntry::make('target_fill_weight_mg')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('actual_fill_weight_mg')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('predicted_eq_ratio')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('predicted_pH_raw')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('compliance_pH')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('predicted_co2_ml')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('predicted_cost_per_unit')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('approval_state')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
