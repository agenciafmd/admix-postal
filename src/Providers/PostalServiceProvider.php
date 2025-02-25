<?php

namespace Agenciafmd\Postal\Providers;

use Illuminate\Support\ServiceProvider;

class PostalServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->bootProviders();

        $this->bootMigrations();

        $this->bootTranslations();

        $this->bootPublish();
    }

    public function register(): void
    {
        $this->registerConfigs();
    }

    private function bootProviders(): void
    {
        $this->app->register(BladeServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(LivewireServiceProvider::class);
    }

    private function bootPublish(): void
    {
        $this->publishes([
            __DIR__ . '/../../config' => base_path('config'),
        ], 'admix-postal:config');

        $this->publishes([
            __DIR__ . '/../../database/seeders/PostalTableSeeder.php' => base_path('database/seeders/PostalTableSeeder.php'),
        ], 'admix-postal:seeders');

        $this->publishes([
            __DIR__ . '/../../lang/pt_BR' => lang_path('pt_BR'),
        ], ['admix-postal:translations', 'admix-translations']);

        //        $this->publishes([
        //            __DIR__ . '/../../public' => public_path('vendor/admix'),
        //        ], ['admix:assets', 'laravel-assets']);
    }

    private function bootMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    private function bootTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'admix-postal');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../../lang');
    }

    private function registerConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/admix-postal.php', 'admix-postal');
        $this->mergeConfigFrom(__DIR__ . '/../../config/audit-alias.php', 'audit-alias');
    }
}
