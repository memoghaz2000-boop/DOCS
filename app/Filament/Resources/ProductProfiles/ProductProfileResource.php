<?php

namespace App\Filament\Resources\ProductProfiles;

use App\Filament\Resources\ProductProfiles\Pages\CreateProductProfile;
use App\Filament\Resources\ProductProfiles\Pages\EditProductProfile;
use App\Filament\Resources\ProductProfiles\Pages\ListProductProfiles;
use App\Filament\Resources\ProductProfiles\Pages\ViewProductProfile;
use App\Filament\Resources\ProductProfiles\Schemas\ProductProfileForm;
use App\Filament\Resources\ProductProfiles\Schemas\ProductProfileInfolist;
use App\Filament\Resources\ProductProfiles\Tables\ProductProfilesTable;
use App\Models\ProductProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductProfileResource extends Resource
{
    protected static ?string $model = ProductProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function getNavigationLabel(): string
    {
        return __('messages.product_profiles');
    }

    public static function getModelLabel(): string
    {
        return __('messages.product_profiles');
    }

    public static function form(Schema $schema): Schema
    {
        return ProductProfileForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductProfileInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductProfilesTable::configure($table);
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
            'index' => ListProductProfiles::route('/'),
            'create' => CreateProductProfile::route('/create'),
            'view' => ViewProductProfile::route('/{record}'),
            'edit' => EditProductProfile::route('/{record}/edit'),
        ];
    }
}
