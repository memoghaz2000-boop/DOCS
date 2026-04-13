<?php

namespace App\Filament\Resources\ProductProfiles\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductProfileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('project_id')
                    ->numeric(),
                TextEntry::make('strength_mg')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('fill_weight_target_mg')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('target_effervescence_sec')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('target_pH')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('pH_low')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('pH_high')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('target_f2_min')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('max_moisture_pct')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('max_cu_rsd_pct')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('rh_limit_pct')
                    ->numeric()
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
