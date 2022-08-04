<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use AshAllenDesign\ConfigValidator\Services\ConfigValidator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /** 
         * This action will block dusk tests, because
         * Dusk environement has own environement settings
         *  */
        // if (App::environment() === 'local') {

        //     (new ConfigValidator())
        //         ->run();
        // }

        // Carbon Time Language
        $lang = (Config::get('app.locale'));
        Carbon::setLocale($lang);
    }
}
