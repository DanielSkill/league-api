<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MatchesRepository;

class MatchListController extends Controller
{
    /**
     * @var MatchesRepository
     */
    protected $matchesRepository;

    /**
     * MatchListController Constructor
     *
     * @param MatchesRepository $matchesRepository
     */
    public function __construct(MatchesRepository $matchesRepository)
    {
        $this->matchesRepository =  $matchesRepository;
    }

    /**
     * Get a summoners match history by passing some form of identification
     *
     * @param int|string $identity
     * @return Illuminate\Http\Response
     */
    public function getMatchesByIdentity($identity)
    {
        $matches = $this->matchesRepository->getMatchListByAccountId($identity);

        return response()->json($matches);
    }
}
