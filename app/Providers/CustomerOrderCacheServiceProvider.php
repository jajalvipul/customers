<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

class CustomerOrderCacheServiceProvider extends ServiceProvider
{
    private $cache_key_customer_orders_count = 'cache_customerOrderCount';

    // cache expires at
    private $expiresAt;

    public function __construct(\Illuminate\Contracts\Foundation\Application  $app)
    {
        parent::__construct($app);
        // cache expires after 5 minutes
        $minutes = env('CUSTOMISED_CACHE_TIMEOUT');
        $this->expiresAt = now()->addMinutes($minutes);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Checking for Customer order count cache and may be used to determine if it exists in the cache.
     *
     * This method will return false if the value is  null or false:
     *
     * @return bool
     */
    public function hasCustomerOrderCount() {
        if (Cache::has($this->cache_key_customer_orders_count)) {
            return true;
        } else {
            return false;
        }

    }

    public function getCustomerOrderCount() {
        return Cache::get($this->cache_key_customer_orders_count);
    }

    public function putCustomerOrderCount($customers) {
        // populate the cache
        Cache::put($this->cache_key_customer_orders_count, $customers, $this->expiresAt);
    }

}
