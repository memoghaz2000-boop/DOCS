<?php

namespace App\Filament\Resources\Apis;

use App\Filament\Resources\Apis\Pages\CreateApi;
use App\Filament\Resources\Apis\Pages\EditApi;
use App\Filament\Resources\Apis\Pages\ListApis;
use App\Filament\Resources\Apis\Pages\ViewApi;
use App\Filament\Resources\Apis\Schemas\ApiForm;
use App\Filament\Resources\Apis\Schemas\ApiInfolist;
use App\Filament\Resources\Apis\Tables\ApisTable;
use App\Models\Api;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ApiResource extends Resource
{
    protected static ?string $model = Api::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationLabel(): string
    {
        return __('messages.apis');
    }

    public static function getModelLabel(): string
    {
        return __('messages.apis');
    }

    public static function form(Schema $schema): Schema
    {
        return ApiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ApiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApis::route('/'),
            'create' => CreateApi::route('/create'),
            'view' => ViewApi::route('/{record}'),
            'edit' => EditApi::route('/{record}/edit'),
        ];
    }
}
