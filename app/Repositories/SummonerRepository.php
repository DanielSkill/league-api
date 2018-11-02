<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use App\Contracts\Repositories\SummonerRepositoryInterface;

class SummonerRepository extends BaseApiRepository implements SummonerRepositoryInterface
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
     * @return object
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
     * @return object
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
     * @return object
     */
    public function getSummonerByAccountId(int $id)
    {
        $response = $this->apiRequest('GET', 'summoners/by-account/' . $id);

        return $response;
    }

}
