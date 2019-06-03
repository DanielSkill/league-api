<?php

namespace App\Contracts\Repositories;

interface MatchesRepositoryInterface
{
    public function getMatchListByAccountId($id, array $options);
}
