<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\BlogPostServiceInterface;
use App\Services\BlogPostService;
use App\Interfaces\UserServiceInterface;
use App\Services\UserService;
use App\Interfaces\CommentServiceInterface;
use App\Services\CommentService;
use App\Interfaces\AuthServiceInterface;
use App\Services\AuthService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(BlogPostServiceInterface::class, BlogPostService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    public function boot(): void
    {
        //
    }
}

