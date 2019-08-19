<?php

namespace App\Providers;

use App\Support\LeagueAPI\MatchApi;
use App\Support\LeagueAPI\SummonerApi;
use Illuminate\Support\ServiceProvider;
use App\Repositories\SummonerRepository;
use App\Contracts\Support\LeagueAPI\MatchApiInterface;
use App\Contracts\Support\LeagueAPI\SummonerApiInterface;
use App\Contracts\Repositories\SummonerRepositoryInterface;

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
            SummonerApiInterface::class,
            SummonerApi::class
        );

        $this->app->bind(
            MatchApiInterface::class,
            MatchApi::class
        );

        $this->app->bind(
            SummonerRepositoryInterface::class,
            SummonerRepository::class
        );
    }
}
