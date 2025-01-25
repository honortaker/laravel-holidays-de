<?php

namespace Honortaker\LaravelHolidaysDe;

use Honortaker\LaravelHolidaysDe\Console\Commands\HolidaysImportCommand;
use Illuminate\Support\ServiceProvider;

class LaravelHolidaysDeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPublications();
        $this->registerCommands();
        $this->mergeConfigFrom(__DIR__ . '/../config/holidays-de.php', 'holidays-de');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function registerPublications(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }
        $this->publishes([
            __DIR__ . '/../config/holidays-de.php' => config_path('holidays-de.php'),
        ], 'holiday-config');
    }

    protected function registerCommands(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }
        $this->commands([
            HolidaysImportCommand::class,
        ]);
    }
}
