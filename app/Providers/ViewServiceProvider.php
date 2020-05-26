<?php

namespace App\Providers;

use App\Http\View\Composers\ActivityComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
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
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['post.index', 'post.myPosts', 'post.myTrashedPosts'], ActivityComposer::class);
    }
}
