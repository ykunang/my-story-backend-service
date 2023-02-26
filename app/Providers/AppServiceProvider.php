<?php

namespace App\Providers;

use App\Http\Services\AuthService;
use App\Http\Services\AuthServiceImpl;
use App\Http\Services\StoryService;
use App\Http\Services\StoryServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthService::class, AuthServiceImpl::class);
        $this->app->bind(StoryService::class, StoryServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
