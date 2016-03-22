<?php

namespace Sikasir\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\Sikasir\V1\Interfaces\CurrentUser::class, \Sikasir\V1\User\EloquentUser::class);
    }
}
