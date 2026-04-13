<?php

namespace App\Filament\Resources\RiskRecords\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RiskRecordsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.project_name')
                    ->label(__('messages.project_name'))
                    ->sortable(),
                TextColumn::make('failure_mode')
                    ->label(__('messages.failure_mode'))
                    ->searchable(),
                TextColumn::make('severity')
                    ->label(__('messages.severity'))
                    ->sortable(),
                TextColumn::make('occurrence')
                    ->label(__('messages.occurrence'))
                    ->sortable(),
                TextColumn::make('detectability')
                    ->label(__('messages.detectability'))
                    ->sortable(),
                TextColumn::make('rpn')
                    ->label(__('messages.rpn'))
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => $state > 100 ? 'danger' : ($state > 50 ? 'warning' : 'success')),
                TextColumn::make('risk_owner')
                    ->label(__('messages.risk_owner'))
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('review_date')
                    ->label(__('messages.review_date'))
                    ->date()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
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
