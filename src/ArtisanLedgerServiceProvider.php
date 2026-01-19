<?php

namespace Ilbullo\ArtisanLedger;

use Illuminate\Support\ServiceProvider;

class ArtisanLedgerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/artisan-ledger.php', 'artisan-ledger');
    }

    public function boot()
    {
        // Carichiamo le migrazioni SEMPRE, non solo in console
        // Questo permette a Laravel di registrarle correttamente nel registro globale
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/artisan-ledger.php' => config_path('artisan-ledger.php'),
            ], 'artisan-ledger-config'); // È buona norma dare un tag specifico
        }

        // Registriamo il servizio nel container di Laravel
        $this->app->singleton('artisan-ledger', function ($app) {
            return new \Ilbullo\ArtisanLedger\Services\LedgerService();
        });

        // Registrazione dinamica del componente Livewire
        if (class_exists(\Livewire\Livewire::class)) {
            \Livewire\Livewire::component('ledger-editor', \Ilbullo\ArtisanLedger\Livewire\LedgerEditor::class);
            \Livewire\Livewire::component('ledger-yearly-overview', \Ilbullo\ArtisanLedger\Livewire\LedgerYearlyOverview::class);
            \Livewire\Livewire::component('ledger-monthly-detail', \Ilbullo\ArtisanLedger\Livewire\LedgerMonthlyDetail::class);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'artisan-ledger');
    }
}
