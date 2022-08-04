<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        // This Affects normal test, can't take
        // $app['config']->set('database.default', 'dusk_testing');
        
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
