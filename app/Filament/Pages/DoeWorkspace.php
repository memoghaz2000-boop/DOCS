<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class DoeWorkspace extends Page
{
    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-presentation-chart-line';
    }
    protected static ?string $navigationLabel = 'DOE Workspace';

    public static function getNavigationGroup(): ?string
    {
        return 'Laboratory';
    }

    protected string $view = 'filament.pages.doe-workspace';
    
    // This is a placeholder for statistical algorithms, matricies and optimization models
    // Since DOE algorithms can be complex, they would normally be instantiated here 
    // and passed to the view or integrated with a Python/R microservice.
}
