<?php

namespace App\Http\Controllers;

use App\Models\Summoner;
use Illuminate\Http\Request;
use App\Repositories\SummonerRepository;
use App\Services\MatchService;

class ProfileController extends Controller
{
    /**
     * @var SummonerRepository
     */
    protected $summonerRepository;

    /**
     * @var MatchService
     */
    protected $matchService;

    /**
     * @param SummonerRepository $summonerRepository
     */
    public function __construct(SummonerRepository $summonerRepository, MatchService $matchService)
    {
        $this->matchService = $matchService;
        $this->summonerRepository = $summonerRepository;
    }

    /**
     * Get summoner profile
     *
     * @param string $name
     * @return Response
     */
    public function getProfile($name)
    {
        $summoner = $this->summonerRepository->getSummonerByName($name);

        $this->matchService->loadRecentGames($summoner->account_id);

        return Summoner::with('matches.participants')->find($summoner->id);
    }

    public function updateProfile($identity)
    {
        // Find summoner if already in database

        // If they have no games fetch past 10 games
            // find matchlist then filter out all games already stored in the database
            // and only fetch the detailed information for games that we don't currently have
        
        // Return summoner information with
    }
}
