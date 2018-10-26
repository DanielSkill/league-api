<?php

namespace App\Repositories;

use GuzzleHttp\Client;

class BaseApiRepository
{
    /**
     * Type of request to the api
     *
     * @var string
     */
    protected $type;
    
    /**
     * Server to perform the request against
     *
     * @var string
     */
    protected $server;

    /**
     * Guzzle http client
     *
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * BaseApiRepository construct
     */
    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'X-Riot-Token' => config('riot.riot-games-api-key'),
            ],
        ]);
    }

    /**
     * Specified server
     * 
     * @param  string $server
     * @return object
     */
    public function server($server = 'euw1')
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Form the url endpoint to the api
     *
     * @return string
     */
    protected function buildUrl($end)
    {
        $this->server = $this->server != null ? $this->server : config('riot.default-region');

        return 'https://' . $this->server . '.api.riotgames.com/lol/' . $this->type . '/v3/' . $end;
    }

    /**
     * Return the response as json
     *
     * @param object $response
     * @return object
     */     
    protected function parseResponse($response)
    {
        return json_decode($response, true);
    }
}