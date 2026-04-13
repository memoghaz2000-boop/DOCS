<?php

namespace App\Filament\Resources\Experiments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExperimentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.project_name')->label(__('messages.project_name'))->sortable(),
                TextColumn::make('formula.formula_code')->label(__('messages.formula_code'))->sortable(),
                TextColumn::make('experiment_type')
                    ->label(__('messages.experiment_type'))
                    ->searchable(),
                TextColumn::make('experiment_code')
                    ->label(__('messages.experiment_code'))
                    ->searchable(),
                TextColumn::make('batch_size')
                    ->label(__('messages.batch_size'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('equipment_used')
                    ->label(__('messages.equipment_used'))
                    ->searchable(),
                TextColumn::make('process_route')
                    ->label(__('messages.process_route'))
                    ->searchable(),
                TextColumn::make('run_status')
                    ->label(__('messages.run_status'))
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
