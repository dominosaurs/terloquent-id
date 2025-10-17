<?php

declare(strict_types=1);

namespace TerloquentID\Providers;

use Illuminate\Support\ServiceProvider;
use TerloquentID\Console\Commands;

class TerloquentIDServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\Clear::class,
                Commands\Status::class,
            ]);

            $this->optimizes(
                clear: 'terloquent:clear',
            );
        }
    }
}
