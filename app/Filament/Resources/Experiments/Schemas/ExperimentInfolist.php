<?php

namespace App\Filament\Resources\Experiments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExperimentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('project_id')
                    ->numeric(),
                TextEntry::make('formula_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('experiment_type')
                    ->placeholder('-'),
                TextEntry::make('experiment_code')
                    ->placeholder('-'),
                TextEntry::make('batch_size')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('equipment_used')
                    ->placeholder('-'),
                TextEntry::make('process_route')
                    ->placeholder('-'),
                TextEntry::make('objective')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('run_status')
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
