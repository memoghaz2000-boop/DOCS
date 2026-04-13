<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('project_code')
                    ->placeholder('-'),
                TextEntry::make('project_name')
                    ->placeholder('-'),
                TextEntry::make('api_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('dosage_form')
                    ->placeholder('-'),
                TextEntry::make('development_stage')
                    ->placeholder('-'),
                TextEntry::make('reference_product')
                    ->placeholder('-'),
                TextEntry::make('target_market')
                    ->placeholder('-'),
                TextEntry::make('project_status')
                    ->placeholder('-'),
                TextEntry::make('owner')
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
