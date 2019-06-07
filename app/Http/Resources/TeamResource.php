<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'id' => $this->id,
            'win' => $this->win,
            'baron_kills' => $this->baron_kills,
            'dragon_kills' => $this->dragon_kills,
            'first_baron' => $this->first_baron,
            'first_blood' => $this->first_blood,
            'first_dragon' => $this->first_dragon,
            'first_inhibitor' => $this->first_inhibitor,
            'first_rift_herald' => $this->first_rift_herald,
            'first_tower' => $this->first_tower,
            'inhibitor_kills' => $this->inhibitor_kills,
            'match_id' => $this->match_id,
            'rift_herald_kills' => $this->rift_herald_kills,
            'team_id' => $this->team_id,
            'tower_kills' => $this->tower_kills,
            'vilemaw_kills' => $this->vilemaw_kills,
            'participants' => ParticipantResource::collection($this->participants->where('team_id', $this->team_id))
        ];
    }
}
