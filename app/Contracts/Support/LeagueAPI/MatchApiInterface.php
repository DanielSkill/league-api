<?php

namespace App\Contracts\Support\LeagueAPI;

interface MatchApiInterface
{
    public function getMatchListByAccountId($id, array $options);
}
