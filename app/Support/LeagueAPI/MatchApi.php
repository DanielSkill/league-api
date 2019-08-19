<?php

namespace App\Support\LeagueAPI;

use App\Support\LeagueAPI\APIResponse;
use App\Support\LeagueAPI\BaseApiClient;
use App\Contracts\Support\LeagueAPI\MatchApiInterface;

class MatchApi extends BaseApiClient implements MatchApiInterface
{
    /**
     * Type of api data request
     *
     * @var string
     */
    protected $type = 'match';

    /**
     * Get users recent matchlist
     *
     * @param string $id
     * @param array $options
     * @return APIResponse
     */
    public function getMatchList($id, array $options)
    {
        $match_list = $this->apiRequest('GET', 'matchlists/by-account/' . $id, $options);

        return $match_list;
    }

    /**
     * Get game details by a game id
     *
     * @param int $id
     * @return APIResponse
     */
    public function getMatchDetailsByGameId($id)
    {
        $match_details = $this->apiRequest('GET', 'matches/' . $id);

        return $match_details;
    }

    /**
     * Get game timeline by a game id
     *
     * @param int $id
     * @return APIResponse
     */
    public function getMatchTimelineByGameId($id)
    {
        $match_timeline = $this->apiRequest('GET', 'timelines/by-match/' . $id);

        return $match_timeline;
    }

    /**
     * Get game details by a game id
     *
     * @param int $id
     * @return void
     */
    public function queueMatchDetailsByGameId($id)
    {
        $this->queueApiRequest($id . '-details', 'matches/' . $id);

        return $this;
    }

    /**
     * Get game timeline by a game id
     *
     * @param int $id
     * @return void
     */
    public function queueMatchTimelineByGameId($id)
    {
       $this->queueApiRequest($id . '-timeline', 'timelines/by-match/' . $id);

       return $this;
    }
}
