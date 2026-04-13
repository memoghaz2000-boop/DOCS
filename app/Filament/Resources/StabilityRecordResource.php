<?php

namespace App\Filament\Resources;

use App\Models\StabilityRecord;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class StabilityRecordResource extends Resource
{
    protected static ?string $model = StabilityRecord::class;

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-clock';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Laboratory';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'project_name')
                    ->required(),
                Select::make('formula_id')
                    ->relationship('formula', 'formula_code')
                    ->required(),
                TextInput::make('condition')
                    ->label('Storage Condition (e.g., 40°C/75% RH)')
                    ->required(),
                TextInput::make('timepoint')
                    ->label('Timepoint (e.g., 3 Months)')
                    ->required(),
                TextInput::make('results')
                    ->label('Results Summary (e.g., STABLE, FAIL)'),
                TextInput::make('trend_flags')
                    ->label('Trend Flags'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.project_name')->label('Project'),
                TextColumn::make('formula.formula_code')->label('Formula'),
                TextColumn::make('condition'),
                TextColumn::make('timepoint'),
                TextColumn::make('results')->badge()
                    ->color(fn (string $state): string => match (strtoupper($state)) {
                        'STABLE' => 'success',
                        'PASS' => 'success',
                        'FAIL' => 'danger',
                        default => 'warning',
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\StabilityRecordResource\Pages\ListStabilityRecords::route('/'),
            'create' => \App\Filament\Resources\StabilityRecordResource\Pages\CreateStabilityRecord::route('/create'),
            'edit' => \App\Filament\Resources\StabilityRecordResource\Pages\EditStabilityRecord::route('/{record}/edit'),
        ];
    }
}
