<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        Schema::defaultStringLength(191);
        if(config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
