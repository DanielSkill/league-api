<?php

namespace App\Contracts\Support\LeagueAPI;

interface SummonerApiInterface
{
    public function getSummonerByName(string $name);

    public function getSummonerBySummonerId(int $id);

    public function getSummonerByAccountId(int $id);
}
