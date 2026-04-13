<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project_code')
                    ->label(__('messages.project_code'))
                    ->searchable(),
                TextColumn::make('project_name')
                    ->label(__('messages.project_name'))
                    ->searchable(),
                TextColumn::make('api.name')
                    ->label(__('messages.api_name'))
                    ->sortable(),
                TextColumn::make('dosage_form')
                    ->label(__('messages.dosage_form'))
                    ->searchable(),
                TextColumn::make('development_stage')
                    ->label(__('messages.development_stage'))
                    ->searchable(),
                TextColumn::make('reference_product')
                    ->label(__('messages.reference_product'))
                    ->searchable(),
                TextColumn::make('target_market')
                    ->searchable(),
                TextColumn::make('project_status')
                    ->searchable(),
                TextColumn::make('owner')
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
