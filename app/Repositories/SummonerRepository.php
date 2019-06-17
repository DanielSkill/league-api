<?php

namespace App\Repositories;

use App\Models\Summoner;
use App\Contracts\Support\LeagueAPI\SummonerApiInterface;

class SummonerRepository
{
    /**
     * @var SummonerApiInterface
     */
    protected $summonerApi;

    /**
     * @param SummonerApiInterface $summonerApi
     */
    public function __construct(SummonerApiInterface $summonerApi)
    {
        $this->summonerApi = $summonerApi;
    }

    /**
     * Get summoner from the database, if they don't exist get them from api
     * and store in the database
     *
     * @param string $server
     * @param string $name
     * @param bool $update
     * @return object
     */
    public function getSummonerByName(string $server, string $name, bool $update = false)
    {
        // find summoner in database
        // TODO: make the find work like the api for example 'h ell o' should match 'hello'
        $summoner = Summoner::where('name', $name)->where('server', $server)->first();

        // match data doesn't provide summoner level so lets update that if it is null
        if (! $summoner || $summoner->summoner_level == null || $update) {
            $response = $this->summonerApi->server($server)->getSummonerByName($name);

            $summoner = Summoner::updateOrCreate(
                [
                    'summoner_id' => $response['id'],
                    'server' => $server
                ],
                [
                    'server' => $server,
                    'summoner_id' => $response['id'],
                    'account_id' => $response['accountId'],
                    'puuid' => $response['puuid'],
                    'name' => $response['name'],
                    'summoner_level' => $response['summonerLevel'],
                    'profile_icon_id' => $response['profileIconId'],
                    'revision_date' => $response['revisionDate'],
                ]
            );
        }

        return $summoner;
    }
}
