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
     * @param int $id
     * @param int|null $end_time
     * @param int|null $begin_index
     * @param int|null $champion
     * @param int|null $end_index
     * @param int|null $queue
     * @param int|null $season
     * @return array
     */
    public function getMatchListByAccountId($id, $end_time = null, $begin_index = null, $champion = null, $end_index = 10, $queue = null, $season = null)
    {
        // Get the initial list of games to use the gameId for more detailed info
        $matches = $this->client->request('GET', $this->buildUrl('matchlists/by-account/' . $id), [
            'query' => [
                'endTime' => $end_time,
                'beginIndex' => $begin_index,
                'champion' => $champion,
                'endIndex' => $end_index,
                'queue' => $queue,
                'season' => $season,
            ]
        ]);

        $match_list = $this->parseResponse($matches->getBody());

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
    public function getMatchDetailsByGameId($id)
    {
        $match_details = $this->client->request('GET', $this->buildUrl('matches/' . $id));

        return $this->parseResponse($match_details->getBody());
    }
}