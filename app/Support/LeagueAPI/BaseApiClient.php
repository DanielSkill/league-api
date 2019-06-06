<?php

namespace App\Support\LeagueAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use hamburgscleanest\GuzzleAdvancedThrottle\RequestLimitRuleset;
use hamburgscleanest\GuzzleAdvancedThrottle\Middleware\ThrottleMiddleware;

abstract class BaseApiClient
{
    /**
     * Type of request to the api
     *
     * @var Client
     */
    protected $client;

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
     * An array of promises
     *
     * @var array
     */
    public $promises = [];

    /**
     * Setup guzzle client in constructor
     */
    public function __construct()
    {
        $this->client = $this->getClient();
    }

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
        $response = $this->client
            ->$method($this->buildUrl($url), [
                'query' => $params
            ]);

        return $this->parseResponse($response->getBody());
    }

    /**
     * Adds a guzzle request to the api promise queue
     *
     * @param mixed $accessor
     * @param string $url
     * @param array $params
     * @return void
     */
    public function queueApiRequest($accessor, string $url, array $params = [])
    {
        $this->promises[$accessor] = $this->client
            ->getAsync($this->buildUrl($url), [
                'query' => $params,
            ]);

        return $this;
    }

    /**
     * Returns all queued promises
     *
     * @return array
     */
    public function getAllQueuedRequests()
    {
        return Promise\settle($this->promises)->wait();
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

        return 'https://' . $this->server . '.api.riotgames.com/lol/' . $this->type . '/v' . config('riot.api-version') . '/' . $end;
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
        // TODO: create rule for each region / method
        $rules = new RequestLimitRuleset([
            'https://{region}.api.riotgames.com' => [
                [
                    'max_requests' => 20,
                    'request_interval' => 1,
                ],
                [
                    'max_requests' => 100,
                    'request_interval' => 120,
                ],
            ],
        ]);


        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());

        $throttle = new ThrottleMiddleware($rules);
        $stack->push($throttle());

        return new Client([
            'headers' => [
                'X-Riot-Token' => config('riot.riot-games-api-key'),
            ],
            'handler' => $stack
        ]);
    }
}
