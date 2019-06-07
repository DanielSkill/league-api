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
     * @param string $server
     * @param string $name
     * @return Response
     */
    public function getProfile(string $server, string $name)
    {
        $summoner = $this->summonerRepository->getSummonerByName($server, $name);

        return Summoner::with('matches.participants')->find($summoner->id);
    }

    /**
     * See if we don't have any of the users recent past games and save required games to
     * the database, return new summoner information after.
     *
     * @param string $server
     * @param string $name
     * @return Response
     */
    public function updateProfile(string $server, string $name)
    {
        $summoner = $this->summonerRepository->getSummonerByName($server, $name, true);

        $this->matchService->loadRecentGames($summoner, $summoner->isInitialLoad() ? 20 : 10);

        return Summoner::with('matches.participants', 'matches.teams')->find($summoner->id);
    }
}
