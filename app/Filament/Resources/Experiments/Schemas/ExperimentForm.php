<?php

namespace App\Filament\Resources\Experiments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ExperimentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->label(__('messages.projects'))
                    ->relationship('project', 'project_name')
                    ->required(),
                Select::make('formula_id')
                    ->label(__('messages.formulas'))
                    ->relationship('formula', 'formula_code'),
                TextInput::make('experiment_type')
                    ->label(__('messages.experiment_type'))
                    ->default(null),
                TextInput::make('experiment_code')
                    ->label(__('messages.experiment_code'))
                    ->default(null),
                TextInput::make('batch_size')
                    ->label(__('messages.batch_size'))
                    ->numeric()
                    ->default(null),
                TextInput::make('equipment_used')
                    ->label(__('messages.equipment_used'))
                    ->default(null),
                TextInput::make('process_route')
                    ->label(__('messages.process_route'))
                    ->default(null),
                Textarea::make('objective')
                    ->label(__('messages.objective'))
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('run_status')
                    ->label(__('messages.run_status'))
                    ->default(null),
            ]);
    }
}
