<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

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
     * A wrapper method for making api calls to the riot api
     *
     * @param string $method
     * @param string $url
     * @param array $params
     * @return mixed
     */
    public function apiRequest(string $method, string $url, array $params = [])
    {
        $response = $this->getClient()
            ->$method($this->buildUrl($url), [
                'query' => $params
            ]);

        return $this->parseResponse($response->getBody());
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
     * @param string $end
     * @return string
     */
    protected function buildUrl(string $end)
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

    /**
     * Returns an instance of guzzle client
     *
     * @return GuzzleHttp\Client
     */
    protected function getClient()
    {
        return new Client([
            'headers' => [
                'X-Riot-Token' => config('riot.riot-games-api-key'),
            ],
        ]);
    }
}