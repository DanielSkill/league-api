<?php

namespace App\Providers;

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
        $this->app->bind(
            'App\Contracts\Repositories\SummonerRepositoryInterface',
            'App\Repositories\SummonerRepository'
        );

        $this->app->bind(
            'App\Contracts\Repositories\MatchesRepositoryInterface',
            'App\Repositories\MatchesRepository'
        );
    }
}
