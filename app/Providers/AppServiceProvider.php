<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SpoonacularService;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
{
    $this->app->singleton(SpoonacularService::class, function () {
        return new SpoonacularService(config('services.spoonacular.key'));
    });
}
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
