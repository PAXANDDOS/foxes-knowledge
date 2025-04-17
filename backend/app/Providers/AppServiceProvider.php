<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (config('app.env') === 'local') {
            try {
                $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            } catch (\Throwable $ignored) {
            }
        }
    }

    public function boot(): void
    {
    }
}
