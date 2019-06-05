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
            'App\Contracts\Support\LeagueAPI\SummonerApiInterface',
            'App\Support\LeagueAPI\SummonerApi'
        );

        $this->app->bind(
            'App\Contracts\Support\LeagueAPI\MatchApiInterface',
            'App\Support\LeagueAPI\MatchApi'
        );
    }
}
