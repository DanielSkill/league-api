<?php

namespace App\Contracts\Support\LeagueAPI;

interface MatchApiInterface
{
    public function getMatchListByAccountId($id, array $options);

    public function getMatchDetailsByGameId($id);

    public function getMatchTimelineByGameId($id);

    public function getMatchList($id, array $options);

}
