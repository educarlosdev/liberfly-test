<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\PersonalAccessToken;
use App\Observers\CategoryObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

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
        Category::observe(CategoryObserver::class);
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
