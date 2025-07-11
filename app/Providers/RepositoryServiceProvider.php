<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\{
    PostRepository,
    AlbumRepository,
    CommentRepository,
    TodoRepository,
    UserRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepository::class, function ($app) {
            return new PostRepository(new \App\Models\Post());
        });

        $this->app->bind(AlbumRepository::class, function ($app) {
            return new AlbumRepository(new \App\Models\Album());
        });

        $this->app->bind(CommentRepository::class, function ($app) {
            return new CommentRepository(new \App\Models\Comment());
        });

        $this->app->bind(TodoRepository::class, function ($app) {
            return new TodoRepository(new \App\Models\Todo());
        });

        $this->app->bind(UserRepository::class, function ($app) {
            return new UserRepository(new \App\Models\User());
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
