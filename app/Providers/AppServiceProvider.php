<?php

namespace App\Providers;

use App\Services\CloudflareProtectionService;
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
        $this->app->singleton(CloudflareProtectionService::class, function () {
            return new CloudflareProtectionService(
                (bool) config('cloudflare_protection.monitor_only'),
                config('cloudflare_protection.cloudflare.api_token'),
                config('cloudflare_protection.cloudflare.zone_id'),
                config('cloudflare_protection.cloudflare.ruleset_id'),
                config('cloudflare_protection.cloudflare.rule_id'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
