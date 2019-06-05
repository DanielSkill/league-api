<?php

namespace App\Services;

use App\Models\Match;
use App\Models\Summoner;
use App\Models\Team;
use App\Models\Participant;

class MatchService
{
    /**
     * Save a match to the database
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
            ]);

            foreach ($match['details']['participantIdentities'] as $summoner) {
                Summoner::firstOrCreate(
                    [
                        'summoner_id' => $summoner['player']['summonerId']
                    ],
                    [
                        'summoner_id' => $summoner['player']['summonerId'],
                        'account_id' => $summoner['player']['accountId'],
                        'name' => $summoner['player']['summonerName'],
                        'profile_icon_id' => $summoner['player']['profileIcon'],
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
                    'bans' => json_encode($team['bans'])
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
                    'stats' => json_encode($participant['stats']),
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
            $this->saveMatch($match);
        }
    }
}