<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('project_code')
                    ->label(__('messages.project_code'))
                    ->default(null),
                TextInput::make('project_name')
                    ->label(__('messages.project_name'))
                    ->default(null),
                Select::make('api_id')->relationship('api', 'name'),
                TextInput::make('dosage_form')
                    ->default(null),
                TextInput::make('development_stage')
                    ->default(null),
                TextInput::make('reference_product')
                    ->default(null),
                TextInput::make('target_market')
                    ->default(null),
                TextInput::make('project_status')
                    ->default(null),
                TextInput::make('owner')
                    ->default(null),
            ]);
    }
}
