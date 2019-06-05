<?php

namespace App\Support\DDragonAPI;

use GuzzleHttp\Client;

abstract class BaseApiClient
{
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
     * Get the latest data version for ddragon
     *
     * @return string
     */
    public function getLatestVersion()
    {
        $response = $this->getClient()
            ->get('https://ddragon.leagueoflegends.com/api/versions.json');

        return $this->parseResponse($response->getBody())[0];
    }

    /**
     * Form the url endpoint to the api
     *
     * @param string $file
     * @return string
     */
    protected function buildUrl(string $file)
    {
        $latest_version = $this->getLatestVersion();

        return 'http://ddragon.leagueoflegends.com/cdn/' . $latest_version . '/data/en_US/' . $file . '.json';
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
        return new Client();
    }
}
