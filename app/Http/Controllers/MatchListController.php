<?php

namespace App\Http\Controllers;

use App\Models\Match;
use Illuminate\Http\Request;
use App\Services\MatchService;
use App\Http\Resources\MatchResource;
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
     * MatchListController Constructor
     *
     * @param MatchApiInterface $matchApi
     */
    public function __construct(MatchApiInterface $matchApi, MatchService $matchService)
    {
        $this->matchApi =  $matchApi;
        $this->matchService =  $matchService;
    }

    /**
     * Get a summoners match history by passing some form of identification
     *
     * @param int|string $identity
     * @return Illuminate\Http\Response
     */
    public function getSummonerMatchHistory(Request $request, string $name)
    {
        $match = Match::with('teams.participants.summoner')->latest()->first();

        // return $match;
        return new MatchResource($match);
    }
}
