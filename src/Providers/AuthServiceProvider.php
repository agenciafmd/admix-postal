<?php

namespace Agenciafmd\Postal\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        '\Agenciafmd\Postal\Postal' => '\Agenciafmd\Postal\Policies\PostalPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
