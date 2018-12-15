<?php

namespace App\Providers;

use App\{Category, Post, Tag};
use App\Observers\{
    CategoryObserver,
    PostObserver,
    TagObserver
};
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Category::observe(CategoryObserver::class);
        Post::observe(PostObserver::class);
        Tag::observe(TagObserver::class);
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
}
