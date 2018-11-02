<?php

namespace App\Contracts\Repositories;

interface SummonerRepositoryInterface
{
    public function getSummonerByName(string $name);

    public function getSummonerBySummonerId(int $id);

    public function getSummonerByAccountId(int $id);
}