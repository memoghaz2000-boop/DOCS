<?php

namespace App\Filament\Resources\Formulas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FormulasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.project_name')->label(__('messages.project_name'))->sortable(),
                TextColumn::make('formula_code')
                    ->label(__('messages.formula_code'))
                    ->searchable(),
                TextColumn::make('formula_status')
                    ->label(__('messages.formula_status'))
                    ->searchable(),
                TextColumn::make('target_fill_weight_mg')
                    ->label(__('messages.target_fill_weight'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('actual_fill_weight_mg')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('predicted_eq_ratio')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('predicted_pH_raw')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('compliance_pH')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('predicted_co2_ml')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('predicted_cost_per_unit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('approval_state')
                    ->searchable(),
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
