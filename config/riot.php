<?php

return [
    /**
     * API key to access the riot games api
     */
    'riot-games-api-key' => env('RIOT_GAMES_API_KEY', ''),

    /**
     * The default endpoint to the League Of Legends API
     */
    'default-endpoint' => env('DEFAULT_ENDPOINT', ''),

    /**
     * Default region to make the requests against
     */
    'default-region' => env('DEFAULT_REGION', 'EUW1'),

    /**
     * Default region to make the requests against
     */
    'api-version' => env('RIOT_API_VERSION', '4')
];
