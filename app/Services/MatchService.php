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

            foreach ($match['timeline']['frames'] as $frame) {
                $stored_frame = Frame::create([
                    'match_id' => $match['details']['gameId'],
                    'timestamp' => $frame['timestamp']
                ]);

                $participant_frames = collect($frame['participantFrames']);

                $participant_frames->transform(function ($item) use ($stored_frame) {
                    return [
                        'frame_id' => $stored_frame->id,
                        'current_gold' => $item['currentGold'],
                        'participant_id' => $item['participantId'],
                        'total_gold' => $item['totalGold'],
                        'team_score' => $item['teamScore'] ?? 0,
                        'level' => $item['level'],
                        'minions_killed' => $item['minionsKilled'],
                        'dominion_score' => $item['dominionScore'] ?? 0,
                        'position_x' => $item['position']['x'] ?? 0,
                        'position_y' => $item['position']['y'] ?? 0,
                        'xp' => $item['xp'],
                        'jungle_minions_killed' => $item['jungleMinionsKilled'],
                    ];
                });

                $events = collect($frame['events']);

                $events->transform(function ($item) use ($stored_frame) {
                    return [
                        'frame_id' => $stored_frame->id,
                        'type' => $item['type'],
                        'team_id' => $item['teamId'] ?? null,
                        'participant_id' => $item['participantId'] ?? null,
                        'event_type' => $item['eventType'] ?? null,
                        'tower_type' => $item['towerType'] ?? null,
                        'ascended_type' => $item['ascendedType'] ?? null,
                        'killer_id' => $item['killerId'] ?? null,
                        'level_up_type' => $item['levelUpType'] ?? null,
                        'point_captured' => $item['pointCaptured'] ?? null,
                        'assisting_participant_ids' => null,
                        'ward_type' => $item['wardType'] ?? null,
                        'monster_type' => $item['monsterType'] ?? null,
                        'skill_shot' => $item['skillShot'] ?? null,
                        'victim_id' => $item['victimId'] ?? null,
                        'timestamp' => $item['timestamp'] ?? null,
                        'after_id' => $item['afterId'] ?? null,
                        'monster_sub_type' => $item['monsterSubType'] ?? null,
                        'lane_type' => $item['laneType'] ?? null,
                        'item_id' => $item['itemId'] ?? null,
                        'building_type' => $item['buildingType'] ?? null,
                        'creator_id' => $item['creatorId'] ?? null,
                        'position_x' => $item['position']['x'] ?? null,
                        'position_y' => $item['position']['y'] ?? null,
                        'before_id' => $item['beforeId'] ?? null,
                    ];
                });

                // $stored_frame->participantFrames()->createMany($participant_frames->toArray());
                // $stored_frame->events()->createMany($events->toArray());

                ParticipantFrame::insert($participant_frames->toArray());
                Event::insert($events->toArray());
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
