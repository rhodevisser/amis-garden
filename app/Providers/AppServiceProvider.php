<?php

namespace App\Providers;

use App\Models\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Prevent N+1-problem and eager loads relationships if that has not been done manually
        Model::automaticallyEagerLoadRelationships();

        Route::pattern('id', '[0-9]+');

        Model::preventLazyLoading(! $this->app->isProduction());

        Model::preventSilentlyDiscardingAttributes(! $this->app->isProduction());

    }
}
