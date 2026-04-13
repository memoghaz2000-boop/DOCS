<?php

namespace App\Filament\Resources\ProductProfiles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.project_name')->sortable(),
                TextColumn::make('strength_mg')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fill_weight_target_mg')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('target_effervescence_sec')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('target_pH')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pH_low')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pH_high')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('target_f2_min')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_moisture_pct')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_cu_rsd_pct')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rh_limit_pct')
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
