<?php

namespace Agenciafmd\Postal\Providers;

use Illuminate\Support\ServiceProvider;

class PostalServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->providers();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->publish();
    }

    protected function providers()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
    }

    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'agenciafmd/postal');
    }

    protected function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'agenciafmd/postal');
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../config' => base_path('config'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/mixdinternet/postal'),
        ], 'views');
    }

    public function register()
    {
        $this->loadConfigs();
    }

    protected function loadConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/admix-postal.php', 'admix-postal');
        $this->mergeConfigFrom(__DIR__ . '/../config/gate.php', 'gate');
        $this->mergeConfigFrom(__DIR__ . '/../config/audit-alias.php', 'audit-alias');
    }
}
