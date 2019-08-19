<?php

namespace App\Support\LeagueAPI;

use App\Support\LeagueAPI\APIResponse;
use App\Support\LeagueAPI\BaseApiClient;
use App\Contracts\Support\LeagueAPI\SummonerApiInterface;

class SummonerApi extends BaseApiClient implements SummonerApiInterface
{
    /**
     * Type of api data request
     *
     * @var string
     */
    protected $type = 'summoner';

    /**
     * Get a summoner by their summoner name
     *
     * @param string $name
     * @return APIResponse
     */
    public function getSummonerByName(string $name)
    {
        $response = $this->apiRequest('GET', 'summoners/by-name/' . $name);

        return $response;
    }

    /**
     * Get a summoner by their summoner id
     *
     * @param int $id
     * @return APIResponse
     */
    public function getSummonerBySummonerId(int $id)
    {
        $response = $this->apiRequest('GET', 'summoners/' . $id);

        return $response;
    }

    /**
     * Get a summoner by their account id
     *
     * @param int $id
     * @return APIResponse
     */
    public function getSummonerByAccountId(int $id)
    {
        $response = $this->apiRequest('GET', 'summoners/by-account/' . $id);

        return $response;
    }

}
