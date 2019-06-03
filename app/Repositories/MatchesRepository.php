<?php

namespace App\Repositories;

use App\Contracts\Repositories\MatchesRepositoryInterface;

class MatchesRepository extends BaseApiRepository implements MatchesRepositoryInterface
{
    /**
     * Type of api data request
     *
     * @var string
     */
    protected $type = 'match';

    /**
     * Get a summoners matchlist by their account id, never allow more than 20 games
     * fetched at a time to prevent hitting rate-limits
     *
     * @param mixed $id
     * @param int|null $end_time
     * @param int|null $begin_index
     * @param int|null $champion
     * @param int|null $end_index
     * @param int|null $queue
     * @param int|null $season
     * @return array
     */
    public function getMatchListByAccountId($id, int $end_time = null, int $begin_index = null, int $champion = null, int $end_index = 10, int $queue = null, int $season = null)
    {
        // Get the initial list of games to use the gameId for more detailed info
        $match_list = $this->apiRequest('GET', 'matchlists/by-account/' . $id, [
            'endTime' => $end_time,
            'beginIndex' => $begin_index,
            'champion' => $champion,
            'endIndex' => $end_index,
            'queue' => $queue,
            'season' => $season,
        ]);

        $match_collection = collect();

        // For each match get more detailed game details
        foreach ($match_list["matches"] as $match) {
            $match_details = $this->getMatchDetailsByGameId($match['gameId']);

            $match_collection->push($match_details);
        }

        return $match_collection->toArray();
    }

    /**
     * Get game details by a game id
     *
     * @param int $id
     * @return object
     */
    public function getMatchDetailsByGameId(int $id)
    {
        $match_details = $this->apiRequest('GET', 'matches/' . $id);

        return $match_details;
    }
}
