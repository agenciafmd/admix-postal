<?php

namespace Agenciafmd\Postal\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadBladeComponents();

        $this->loadBladeDirectives();

        $this->loadBladeComposers();

        $this->setMenu();

        $this->loadViews();

        $this->publish();
    }

    public function register(): void
    {
        //
    }

    private function loadBladeComponents(): void
    {
        Blade::componentNamespace('Agenciafmd\\Postal\\Http\\Components', 'admix-postal');
    }

    private function loadBladeComposers(): void
    {
        //
    }

    private function loadBladeDirectives(): void
    {
        //
    }

    private function setMenu(): void
    {
        $this->app->make('admix-menu')
            ->push((object) [
                'component' => 'admix-postal::aside.postal',
                'ord' => config('admix-postal.sort'),
            ]);
    }

    private function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'admix-postal');
    }

    private function publish(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/agenciafmd/postal'),
        ], 'admix-postal:views');
    }
}
