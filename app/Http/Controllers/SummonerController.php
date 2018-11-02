<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Repositories\SummonerRepositoryInterface;

class SummonerController extends Controller
{
    /**
     * @var SummonerRepositoryInterface
     */
    protected $summonerRepository;

    /**
     * SummonerController construct
     *
     * @param SummonerRepositoryInterface $summonerRepository
     */
    public function __construct(SummonerRepositoryInterface $summonerRepository)
    {
        $this->summonerRepository = $summonerRepository;
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
        $user = $this->summonerRepository
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
        $user = $this->summonerRepository
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
        $user = $this->summonerRepository
            ->server($server)
            ->getSummonerByAccountId($id);

        return response()->json($user);
    }
}
