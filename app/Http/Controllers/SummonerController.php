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
     * @return Illuminate\Http\Response
     */
    public function byName($name)
    {
        $user = $this->summonerRepository
            ->server('na1')
            ->getSummonerByName($name);

        return response()->json($user);
    }
}
