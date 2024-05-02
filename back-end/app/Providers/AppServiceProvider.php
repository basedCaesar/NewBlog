<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\BlogPostServiceInterface;
use App\Services\BlogPostService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BlogPostServiceInterface::class, BlogPostService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
