<?php

namespace App\Filament\Resources\Excipients\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExcipientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('excipient_name'),
                TextEntry::make('category')
                    ->placeholder('-'),
                TextEntry::make('mw')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('acid_equivalents')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('base_equivalents')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('pKa_or_buffer_role')
                    ->placeholder('-'),
                TextEntry::make('typical_lod_pct')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('hygroscopicity_level')
                    ->placeholder('-'),
                TextEntry::make('cost_per_mg')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('compatibility_flags')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
