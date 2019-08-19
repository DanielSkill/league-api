<?php

namespace App\Contracts\Repositories;

interface SummonerRepositoryInterface
{
    public function getSummonerByName(string $server, string $name, bool $update);
}