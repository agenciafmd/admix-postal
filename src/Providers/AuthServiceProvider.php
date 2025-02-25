<?php

namespace Agenciafmd\Postal\Providers;

use Agenciafmd\Postal\Models\Postal;
use Agenciafmd\Postal\Policies\PostalPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Postal::class => PostalPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }

    public function register(): void
    {
        $this->registerConfigs();
    }

    public function registerConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/gate.php', 'gate');
    }
}
