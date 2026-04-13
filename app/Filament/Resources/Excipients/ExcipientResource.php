<?php

namespace App\Filament\Resources\Excipients;

use App\Filament\Resources\Excipients\Pages\CreateExcipient;
use App\Filament\Resources\Excipients\Pages\EditExcipient;
use App\Filament\Resources\Excipients\Pages\ListExcipients;
use App\Filament\Resources\Excipients\Pages\ViewExcipient;
use App\Filament\Resources\Excipients\Schemas\ExcipientForm;
use App\Filament\Resources\Excipients\Schemas\ExcipientInfolist;
use App\Filament\Resources\Excipients\Tables\ExcipientsTable;
use App\Models\Excipient;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExcipientResource extends Resource
{
    protected static ?string $model = Excipient::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'excipient_name';

    public static function getNavigationLabel(): string
    {
        return __('messages.excipients');
    }

    public static function getModelLabel(): string
    {
        return __('messages.excipients');
    }

    public static function form(Schema $schema): Schema
    {
        return ExcipientForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExcipientInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExcipientsTable::configure($table);
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
            'index' => ListExcipients::route('/'),
            'create' => CreateExcipient::route('/create'),
            'view' => ViewExcipient::route('/{record}'),
            'edit' => EditExcipient::route('/{record}/edit'),
        ];
    }
}
