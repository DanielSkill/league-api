<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'team_id' => $this->team_id,
            'summoner' => $this->summoner,
            'match_id' => $this->match_id,
            'champion_id' => $this->champion_id,
            'summoner_spell_1' => $this->summoner_spell_1,
            'summoner_spell_2' => $this->summoner_spell_2,
            'highest_achieved_season_tier' => $this->highest_achieved_season_tier,
            'stats' => new StatisticResource($this->stats)
        ];
    }
}
