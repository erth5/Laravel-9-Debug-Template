<?php

namespace App\Providers;

use Carbon\Carbon;
use App\ResourceRegistrar;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use Illuminate\Routing\ResourceRegistrar as BaseResourceRegistrar;

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
    public function boot(): void
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

        /** Carbon Time Language */
        $lang = (Config::get('app.locale'));
        Carbon::setLocale($lang);

        // Using view composer to set following variables globally
        view()->composer('*', function ($view) {
            $view->with('user', Auth::user());
            // $view->with('social', Social::all());
        });

        /**
         * Erweiterung der Resource Routes um eine connection route
        */
        $this->app->bind(BaseResourceRegistrar::class, ResourceRegistrar::class);
    }
    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('global', function () {
            return Limit::perMinute(200);
        });
        RateLimiter::for('downloads', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()->id);
        });
    }
}
