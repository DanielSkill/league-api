<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatisticResource extends JsonResource
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
            'kda' => [
                'kills' => $this->kills,
                'deaths' => $this->deaths,
                'assists' => $this->assists,
            ],
            'items' => [$this->item0, $this->item1, $this->item2, $this->item3, $this->item4, $this->item5, $this->item6]
        ];
    }
}
