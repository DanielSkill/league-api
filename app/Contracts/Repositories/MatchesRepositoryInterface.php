<?php

namespace App\Contracts\Repositories;

interface MatchesRepositoryInterface
{
    public function getMatchListByAccountId(int $id, int $end_time, int $begin_index, int $champion, int $end_index, int $queue, int $season);
}