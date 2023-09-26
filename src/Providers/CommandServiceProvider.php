<?php

namespace Agenciafmd\Postal\Providers;

use Agenciafmd\Admix\Commands\AdmixUser;
use Agenciafmd\Admix\Commands\InstallCommand;
use Agenciafmd\Admix\Commands\NotificationsClear;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }

        $minutes = Cache::rememberForever('schedule-minutes', static function () {
            return Str::of((string)random_int(0, 59))
                ->padLeft(2, '0')
                ->toString();
        });

        $this->app->booted(function () use ($minutes) {
            $schedule = $this->app->make(Schedule::class);
        });
    }
}
