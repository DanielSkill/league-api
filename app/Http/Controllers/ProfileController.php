<?php

namespace App\Http\Controllers;

use App\Models\Summoner;
use Illuminate\Http\Request;
use App\Services\MatchService;
use App\Repositories\SummonerRepository;
use App\Contracts\Repositories\SummonerRepositoryInterface;

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
     * @param SummonerRepositoryInterface $summonerRepository
     * @param MatchService $matchService
     */
    public function __construct(SummonerRepositoryInterface $summonerRepository, MatchService $matchService)
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

        return Summoner::with('matches.teams.participants')->find($summoner->id);
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

        $summoner = Summoner::with('matches.participants', 'matches.teams')->find($summoner->id);

        return $summoner;

        // use for debug bar
        // return view('welcome', compact('summoner'));
    }
}
