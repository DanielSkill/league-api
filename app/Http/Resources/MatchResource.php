<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MatchResource extends JsonResource
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
            'game_id' => $this->game_id,
            'platform_id' => $this->platform_id,
            'game_type' => $this->game_type,
            'duartion' => $this->game_duration,
            'created' => $this->game_creation,
            'blue_team' => new TeamResource($this->teams[0]),
            'red_team' => new TeamResource($this->teams[1]),
        ];
    }
}
