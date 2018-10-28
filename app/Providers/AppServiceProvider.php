<?php

namespace App\Providers;

use Bigcommerce\Api\Client;
use Illuminate\Filesystem\Cache;
use Illuminate\Support\ServiceProvider;
use App\Services\CustomerOrderService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('API_STORE_URL')) {
            Client::configure([
                'store_url' => env('API_STORE_URL'),
                'username' => env('API_USERNAME'),
                'api_key' => env('API_KEY'),
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Register Customer Order Cache ServiceProvider
        $this->app->singleton(App\Providers\CustomerOrderCacheServiceProvider::class, function ($app) {
            return new CustomerOrderCacheServiceProvider($app);
        });

        // Register Customer Order Service
        $this->app->bind('App\Services\CustomerOrderService', function ($app) {
            return new CustomerOrderService();
        });
    }

}
