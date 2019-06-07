<?php

namespace App\Services;

use App\Models\Team;
use App\Models\Event;
use App\Models\Frame;
use App\Models\Match;
use App\Models\Summoner;
use App\Models\Participant;
use Illuminate\Support\Arr;
use App\Models\ParticipantFrame;
use App\Contracts\Support\LeagueAPI\MatchApiInterface;

class MatchService
{
    /**
     * @var MatchApiInterface
     */
    protected $matchApi;

    /**
     * @param MatchApiInterface $matchApi
     */
    public function __construct(MatchApiInterface $matchApi)
    {
        $this->matchApi = $matchApi;
    }

    /**
     * Save a match to the database
     * TODO: TIDY UP AND OPTIMISE
     *
     * @param mixed $match
     * @return void
     */
    public function saveMatch($match)
    {
        if (! Match::where('game_id', $match['details']['gameId'])->first()) {
             // Create the base match
            Match::create([
                'game_id' => $match['details']['gameId'],
                'platform_id' => $match['details']['platformId'],
                'game_creation' => $match['details']['gameCreation'],
                'game_duration' => $match['details']['gameDuration'],
                'queue_id' => $match['details']['queueId'],
                'map_id' => $match['details']['mapId'],
                'season_id' => $match['details']['seasonId'],
                'game_version' => $match['details']['gameVersion'],
                'game_mode' => $match['details']['gameMode'],
                'game_type' => $match['details']['gameType'],
                'timeline' => $match['timeline']
            ]);

            foreach ($match['details']['participantIdentities'] as $summoner) {
                Summoner::firstOrCreate(
                    [
                        'summoner_id' => $summoner['player']['summonerId'],
                        'server' => $match['details']['platformId']
                    ],
                    [
                        'server' => $match['details']['platformId'],
                        'summoner_id' => $summoner['player']['summonerId'],
                        'account_id' => $summoner['player']['accountId'],
                        'name' => $summoner['player']['summonerName'],
                        'profile_icon_id' => $summoner['player']['profileIcon']
                    ]
                );
            }

            foreach ($match['details']['teams'] as $team) {
                Team::create([
                    'match_id' => $match['details']['gameId'],
                    'win' => $team['win'] == "Win",
                    'team_id' => $team['teamId'],
                    'first_blood' => $team['firstBlood'],
                    'first_tower' => $team['firstTower'],
                    'first_inhibitor' => $team['firstInhibitor'],
                    'first_dragon' => $team['firstDragon'],
                    'first_baron' => $team['firstBaron'],
                    'first_rift_herald' => $team['firstRiftHerald'],
                    'tower_kills' => $team['towerKills'],
                    'inhibitor_kills' => $team['inhibitorKills'],
                    'baron_kills' => $team['baronKills'],
                    'dragon_kills' => $team['dragonKills'],
                    'vilemaw_kills' => $team['vilemawKills'],
                    'rift_herald_kills' => $team['riftHeraldKills'],
                    'bans' => $team['bans']
                ]);
            }

            foreach ($match['details']['participants'] as $participant) {
                Participant::create([
                    'summoner_id' => $match['details']['participantIdentities'][$participant['participantId'] - 1]['player']['summonerId'],
                    'match_id' => $match['details']['gameId'],
                    'team_id' => $participant['teamId'],
                    'champion_id' => $participant['championId'],
                    'summoner_spell_1' => $participant['spell1Id'],
                    'summoner_spell_2' => $participant['spell2Id'],
                    'highest_achieved_season_tier' => $participant['highestAchievedSeasonTier'] ?? null,
                    'stats' => $participant['stats'],
                ]);
            }
        }

    }

    /**
     * Save all matches in collection
     *
     * @param array $matches
     * @return void
     */
    public function saveMatches($matches)
    {
        foreach ($matches as $match) {
            $match_details = $this->matchApi->queueMatchDetailsByGameId($match['gameId']);
            $match_timeline = $this->matchApi->queueMatchTimelineByGameId($match['gameId']);
        }

        $matches = $this->matchApi->getAllQueuedRequests();

        $response_collection = [];

        foreach ($matches as $key => $match) {
            $accessor = explode('-', $key);

            $response_collection[$accessor[0]][$accessor[1]] = json_decode($match['value']->getBody(), true);
        }

        foreach ($response_collection as $detailed_match) {
            $this->saveMatch($detailed_match);
        }
    }

     /**
     * Look at users past 10 games and save any that aren't already in the database
     *
     * @param string $id
     * @param integer $count
     * @return array
     */
    public function loadRecentGames(Summoner $summoner, int $count = 10)
    {
        // get array of games
        $games = $this->matchApi->server($summoner->server)
            ->getMatchlist($summoner->account_id, [
                'endIndex' => $count
            ]);

        // get games already in the database
        $existing_matches = Match::whereIn('game_id', array_column($games['matches'], 'gameId'))->pluck('game_id');

        $matches_to_fetch = array_filter($games['matches'], function ($game) use ($existing_matches) {
            return ! in_array($game['gameId'], $existing_matches->toArray());
        });

        $this->saveMatches($matches_to_fetch);
    }
}
