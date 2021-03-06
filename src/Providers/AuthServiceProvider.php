<?php

namespace Agenciafmd\Postal\Providers;

use Agenciafmd\Postal\Policies\PostalPolicy;
use Agenciafmd\Postal\Models\Postal;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Postal::class => PostalPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
