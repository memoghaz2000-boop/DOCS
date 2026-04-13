<?php

namespace App\Filament\Resources\Formulas;

use App\Filament\Resources\Formulas\Pages\CreateFormula;
use App\Filament\Resources\Formulas\Pages\EditFormula;
use App\Filament\Resources\Formulas\Pages\ListFormulas;
use App\Filament\Resources\Formulas\Pages\ViewFormula;
use App\Filament\Resources\Formulas\Schemas\FormulaForm;
use App\Filament\Resources\Formulas\Schemas\FormulaInfolist;
use App\Filament\Resources\Formulas\Tables\FormulasTable;
use App\Models\Formula;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FormulaResource extends Resource
{
    protected static ?string $model = Formula::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'formula_code';

    public static function getNavigationLabel(): string
    {
        return __('messages.formulas');
    }

    public static function getModelLabel(): string
    {
        return __('messages.formulas');
    }

    public static function form(Schema $schema): Schema
    {
        return FormulaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FormulaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormulasTable::configure($table);
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
            'index' => ListFormulas::route('/'),
            'create' => CreateFormula::route('/create'),
            'view' => ViewFormula::route('/{record}'),
            'edit' => EditFormula::route('/{record}/edit'),
        ];
    }
}
