<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Support\LeagueAPI\MatchApiInterface;

class MatchListController extends Controller
{
    /**
     * @var MatchApiInterface
     */
    protected $matchApi;

    /**
     * MatchListController Constructor
     *
     * @param MatchApiInterface $matchApi
     */
    public function __construct(MatchApiInterface $matchApi)
    {
        $this->matchApi =  $matchApi;
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
