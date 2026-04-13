<?php

namespace App\Filament\Resources;

use App\Models\DecisionRecord;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class DecisionRecordResource extends Resource
{
    protected static ?string $model = DecisionRecord::class;

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-document-check';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Compliance & Audit';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'project_name')
                    ->required()
                    ->disabled(), // Decisions are audited, shouldn't be moved manually
                TextInput::make('decision_type')
                    ->required()
                    ->disabled(),
                Textarea::make('rationale')
                    ->columnSpanFull()
                    ->disabled(),
                TextInput::make('linked_evidence')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.project_name')->label('Project')->searchable(),
                TextColumn::make('decision_type')->searchable()->badge(),
                TextColumn::make('rationale')->limit(50),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\DecisionRecordResource\Pages\ListDecisionRecords::route('/'),
        ];
    }

    // Prevent manually creating decisions from UI (it's an automated audit trail)
    public static function canCreate(): bool
    {
        return false;
    }
}
