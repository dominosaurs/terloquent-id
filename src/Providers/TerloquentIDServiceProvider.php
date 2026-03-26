<?php

declare(strict_types=1);

namespace TerloquentID\Providers;

use Illuminate\Support\ServiceProvider;
use TerloquentID\Console\Commands;

final class TerloquentIDServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config.php',
            'terloquent'
        );
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\Clear::class,
                Commands\Status::class,
            ]);

            $this->optimizes(
                clear: 'terloquent-id:clear',
            );
        }
    }
}
