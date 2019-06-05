<?php

namespace App\Support\DDragonAPI;

class DDragonDataApi extends BaseApiClient
{
    /**
     * Returns all champion details
     *
     * @return array
     */
    public function getChampions(bool $full = false)
    {
        $file = $full ? 'championFull' : 'champion';

        return $this->apiRequest('GET', $file);
    }

    /**
     * Returns all runes details
     *
     * @return array
     */
    public function getRunes()
    {
        return $this->apiRequest('GET', 'runesReforged');
    }

    /**
     * Returns all profile icon details
     *
     * @return array
     */
    public function getProfileIcons()
    {
        return $this->apiRequest('GET', 'profileicon');
    }

    /**
     * Returns all item details
     *
     * @return array
     */
    public function getItems()
    {
        return $this->apiRequest('GET', 'item');
    }

    /**
     * Returns all map details
     *
     * @return array
     */
    public function getMaps()
    {
        return $this->apiRequest('GET', 'map');
    }

    /**
     * Returns all summoner spell details
     *
     * @return array
     */
    public function getSummonerSpells()
    {
        return $this->apiRequest('GET', 'summoner');
    }
}
