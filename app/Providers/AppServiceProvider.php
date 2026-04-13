<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\RiskRecord::observe(\App\Observers\RiskRecordObserver::class);
        \App\Models\Project::observe(\App\Observers\ProjectObserver::class);
        \App\Models\Formula::observe(\App\Observers\FormulaObserver::class);
    }
}
