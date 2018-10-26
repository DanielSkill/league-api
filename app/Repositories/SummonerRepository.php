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
    public function getSummonerByName($name)
    {
        $response = $this->client->request('GET', $this->buildUrl('summoners/by-name/' . $name));

        return $this->parseResponse($response->getBody());
    }

    /**
     * Get a summoner by their summoner id
     *
     * @param int $id
     * @return object
     */
    public function getSummonerBySummonerId($id)
    {
        $response = $this->client->request('GET', $this->buildUrl('summoners/' . $id));

        return $this->parseResponse($response->getBody());
    }

    /**
     * Get a summoner by their account id
     *
     * @param int $id
     * @return object
     */
    public function getSummonerByAccountId($id)
    {
        $response = $this->client->request('GET', $this->buildUrl('summoners/by-account/' . $id));

        return $this->parseResponse($response->getBody());
    }

}
