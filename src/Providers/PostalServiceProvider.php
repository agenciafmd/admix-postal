<?php

namespace Agenciafmd\Postal\Providers;

use Agenciafmd\Postal\Models\Postal;
use Illuminate\Support\ServiceProvider;

class PostalServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->providers();

        $this->setSearch();

        $this->loadMigrations();

        $this->publish();
    }

    public function register()
    {
        $this->loadConfigs();
    }

    protected function providers()
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(BladeServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    protected function setSearch()
    {
        $this->app->make('admix-search')
            ->registerModel(Postal::class, 'name');
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../config' => base_path('config'),
        ], 'admix-postal:config');

        $this->publishes([
            __DIR__ . '/../database/seeders/PostalTableSeeder.php.stub' => base_path('database/seeders/PostalTableSeeder.php'),
        ], 'admix-postal:seeders');
    }

    protected function loadConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/admix-postal.php', 'admix-postal');
        $this->mergeConfigFrom(__DIR__ . '/../config/gate.php', 'gate');
        $this->mergeConfigFrom(__DIR__ . '/../config/audit-alias.php', 'audit-alias');
    }
}
