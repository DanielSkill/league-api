<?php

namespace App\Contracts\Repositories;

interface MatchesRepositoryInterface
{
    public function getMatchListByAccountId($id, $end_time, $begin_index, $champion, $end_index, $queue, $season);
}