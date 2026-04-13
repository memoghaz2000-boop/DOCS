<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiskRecords\Pages\CreateRiskRecord;
use App\Filament\Resources\RiskRecords\Pages\EditRiskRecord;
use App\Filament\Resources\RiskRecords\Pages\ListRiskRecords;
use App\Filament\Resources\RiskRecords\Pages\ViewRiskRecord;
use App\Filament\Resources\RiskRecords\Schemas\RiskRecordForm;
use App\Filament\Resources\RiskRecords\Tables\RiskRecordsTable;
use App\Models\RiskRecord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RiskRecordResource extends Resource
{
    protected static ?string $model = RiskRecord::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    public static function getNavigationLabel(): string
    {
        return __('messages.risk_management');
    }

    public static function getModelLabel(): string
    {
        return __('messages.risk_management');
    }

    public static function form(Schema $schema): Schema
    {
        return RiskRecordForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RiskRecordsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRiskRecords::route('/'),
            'create' => CreateRiskRecord::route('/create'),
            'view' => ViewRiskRecord::route('/{record}'),
            'edit' => EditRiskRecord::route('/{record}/edit'),
        ];
    }
}
