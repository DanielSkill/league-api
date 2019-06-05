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

        return $this->getFile($file);
    }

    /**
     * Returns all runes details
     *
     * @return array
     */
    public function getRunes()
    {
        return $this->getFile('runesReforged');
    }

    /**
     * Returns all profile icon details
     *
     * @return array
     */
    public function getProfileIcons()
    {
        return $this->getFile('profileicon');
    }

    /**
     * Returns all item details
     *
     * @return array
     */
    public function getItems()
    {
        return $this->getFile('item');
    }

    /**
     * Returns all map details
     *
     * @return array
     */
    public function getMaps()
    {
        return $this->getFile('map');
    }

    /**
     * Returns all summoner spell details
     *
     * @return array
     */
    public function getSummonerSpells()
    {
        return $this->getFile('summoner');
    }
}
