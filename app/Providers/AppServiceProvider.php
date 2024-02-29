<?php

namespace App\Providers;

use App\Contracts\DataProvider;
use App\DataProviders\DataProviderW;
use App\DataProviders\DataProviderX;
use App\DataProviders\DataProviderY;
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
        $this->app->bind(DataProvider::class, DataProviderX::class);
        $this->app->bind(DataProvider::class, DataProviderW::class);
        $this->app->bind(DataProvider::class, DataProviderY::class);
    }
}
