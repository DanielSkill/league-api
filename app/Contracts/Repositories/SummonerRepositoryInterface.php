<?php

namespace App\Contracts\Repositories;

interface SummonerRepositoryInterface
{
    public function getSummonerByName($name);

    public function getSummonerBySummonerId($id);

    public function getSummonerByAccountId($id);
}