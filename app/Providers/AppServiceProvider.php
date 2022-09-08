<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
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
        $this->configureRateLimiting();

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

        // Using view composer to set following variables globally
        view()->composer('*', function ($view) {
            $view->with('user', Auth::user());
            // $view->with('social', Social::all());
        });
    }
    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(1);
        });
        RateLimiter::for('downloads', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()->id);
        });
    }
}
