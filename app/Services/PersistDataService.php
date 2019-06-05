<?php

namespace App\Services;

use App\Models\Champion;
use Illuminate\Support\Facades\Storage;

class PersistDataService
{
    /**
     * Function to store all champions data in database
     *
     * @return void
     */
    public function saveChampionsData()
    {
        $champions_file = Storage::disk('public')->get('championsFull.json');
        $champions = json_decode($champions_file, true);

        $data = collect();

        foreach ($champions['data'] as $key => $champion) {
            $data->push([
                'key' => $champion['key'],
                'name' => $champion['name'],
                'title' => $champion['title'],
                'blurb' => $champion['blurb'],
                'lore' => $champion['lore'],
                'partype' => $champion['partype'],
                'passive' => json_encode($champion['passive']),
                'skins' => json_encode($champion['skins']),
                'spells' => json_encode($champion['spells']),
                'info' => json_encode($champion['info']),
                'image' => json_encode($champion['image']),
                'tags' => json_encode($champion['tags']),
                'stats' => json_encode($champion['stats'])
            ]);
        }

        Champion::insert($data->toArray());
    }

    public function saveMatchData($match)
    {

    }

    public function savePlayerData($player)
    {

    }
}
