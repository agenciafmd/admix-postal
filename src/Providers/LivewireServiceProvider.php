<?php

namespace Agenciafmd\Postal\Providers;

use Agenciafmd\Postal\Http\Livewire\Pages;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Livewire::component('agenciafmd.postal.http.livewire.pages.postal.index', Pages\Postal\Index::class);
        Livewire::component('agenciafmd.postal.http.livewire.pages.postal.form', Pages\Postal\Form::class);
    }

    public function register(): void
    {
        //
    }
}
