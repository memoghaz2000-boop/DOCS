<?php

namespace App\Filament\Resources;

use App\Models\Packaging;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class PackagingResource extends Resource
{
    protected static ?string $model = Packaging::class;

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-cube';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Master Data';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('material_type')
                    ->required()
                    ->label('Packaging Material (e.g., Alu-Alu Blister)'),
                TextInput::make('wvtr_value')
                    ->numeric()
                    ->label('WVTR (Water Vapor Transmission Rate)')
                    ->suffix('g/m²/day'),
                TextInput::make('thickness')
                    ->label('Thickness'),
                TextInput::make('supplier')
                    ->label('Supplier'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('material_type')->searchable(),
                TextColumn::make('wvtr_value')->sortable(),
                TextColumn::make('thickness'),
                TextColumn::make('supplier'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\PackagingResource\Pages\ListPackagings::route('/'),
            'create' => \App\Filament\Resources\PackagingResource\Pages\CreatePackaging::route('/create'),
            'edit' => \App\Filament\Resources\PackagingResource\Pages\EditPackaging::route('/{record}/edit'),
        ];
    }
}
