<?php

namespace App\Filament\Resources\Excipients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExcipientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('excipient_name')
                    ->searchable(),
                TextColumn::make('category')
                    ->searchable(),
                TextColumn::make('mw')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('acid_equivalents')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('base_equivalents')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pKa_or_buffer_role')
                    ->searchable(),
                TextColumn::make('typical_lod_pct')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('hygroscopicity_level')
                    ->searchable(),
                TextColumn::make('cost_per_mg')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
