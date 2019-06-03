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
     * @param array $options
     * @return array
     */
    public function getMatchListByAccountId($id, array $options)
    {
        // Get the initial list of games to use the gameId for more detailed info
        $match_list = $this->apiRequest('GET', 'matchlists/by-account/' . $id, $options);

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
