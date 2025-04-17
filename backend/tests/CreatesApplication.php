<?php

namespace Tests;

use App\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;

trait CreatesApplication
{
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        Artisan::call('migrate --env=testing');
        Artisan::call('db:seed --env=testing');

        return $app;
    }
}
