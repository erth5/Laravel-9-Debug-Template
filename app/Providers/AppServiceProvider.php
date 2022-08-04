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
        if (App::environment() === 'local') {

            (new ConfigValidator())
                ->run();
        }

        // Carbon Time Language
        $lang = (Config::get('app.locale'));
        Carbon::setLocale($lang);
    }
}
