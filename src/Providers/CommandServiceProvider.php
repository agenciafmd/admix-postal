<?php

namespace Agenciafmd\Postal\Providers;

use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            //
        ]);
    }
}
