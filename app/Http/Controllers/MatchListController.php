<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\SummonerRepositoryInterface;
use App\Models\Match;
use Illuminate\Http\Request;
use App\Services\MatchService;
use App\Http\Resources\MatchResource;
use App\Repositories\SummonerRepository;
use App\Contracts\Support\LeagueAPI\MatchApiInterface;

class MatchListController extends Controller
{
    /**
     * @var MatchApiInterface
     */
    protected $matchApi;

    /**
     * @var MatchService
     */
    protected $matchService;

    /**
     * @var SummonerRepository
     */
    protected $summonerRepository;

    /**
     * @param MatchApiInterface $matchApi
     * @param MatchService $matchService
     * @param SummonerRepositoryInterface $summonerRepository
     */
    public function __construct(
        MatchApiInterface $matchApi,
        MatchService $matchService,
        SummonerRepositoryInterface $summonerRepository)
    {
        $this->matchApi =  $matchApi;
        $this->matchService =  $matchService;
        $this->summonerRepository =  $summonerRepository;
    }

    /**
     * Get a summoners match history by passing some form of identification
     *
     * @param int|string $identity
     * @return Illuminate\Http\Response
     */
    public function getSummonerMatchHistory(Request $request, string $server, string $name)
    {
        $summoner = $this->summonerRepository->getSummonerByName($server, $name);

        $matches = Match::with('teams.participants.summoner')
            ->whereHas('participants', function($q) use ($summoner) {
                $q->where('summoner_id', $summoner->summoner_id);
            })
            ->paginate(20);

        // return $match;
        return MatchResource::collection($matches);
    }
}
