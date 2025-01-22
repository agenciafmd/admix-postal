<?php

namespace Agenciafmd\Postal\Providers;

use Agenciafmd\Postal\Livewire\Pages;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Livewire::component('agenciafmd.postal.livewire.pages.postal.index', Pages\Postal\Index::class);
        Livewire::component('agenciafmd.postal.livewire.pages.postal.component', Pages\Postal\Component::class);
    }

    public function register(): void
    {
        //
    }
}
