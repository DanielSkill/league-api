<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Support\LeagueAPI\SummonerApiInterface;

class SummonerController extends Controller
{
    /**
     * @var SummonerApiInterface
     */
    protected $summonerApi;

    /**
     * SummonerController construct
     *
     * @param SummonerApiInterface $summonerApi
     */
    public function __construct(SummonerApiInterface $summonerApi)
    {
        $this->summonerApi = $summonerApi;
    }

    /**
     * Get a summoner by their name
     *
     * @param string $name
     * @param string $server
     * @return Illuminate\Http\Response
     */
    public function byName(string $name, string $server = null)
    {
        $user = $this->summonerApi
            ->server($server)
            ->getSummonerByName($name);

        return response()->json($user);
    }

    /**
     * Get a summoner by their name
     *
     * @param int $id
     * @param string $server
     * @return Illuminate\Http\Response
     */
    public function bySummonerId(int $id, string $server = null)
    {
        $user = $this->summonerApi
            ->server($server)
            ->getSummonerBySummonerid($id);

        return response()->json($user);
    }

    /**
     * Get a summoner by their name
     *
     * @param int $id
     * @param string $server
     * @return Illuminate\Http\Response
     */
    public function byAccountId(int $id, string $server = null)
    {
        $user = $this->summonerApi
            ->server($server)
            ->getSummonerByAccountId($id);

        return response()->json($user);
    }
}
