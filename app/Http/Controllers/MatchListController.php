<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Support\LeagueAPI\MatchApiInterface;
use App\Services\MatchService;

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
    public function getMatchesByIdentity(Request $request, $identity)
    {
        $matches = $this->matchApi->getMatchListByAccountId($identity, $request->toArray());
        
        return response()->json($matches);
    }
}
