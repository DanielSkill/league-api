<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Support\DDragonAPI\DDragonDataApi;
use Illuminate\Support\Facades\Storage;

class ImportStaticData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:static-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import/Update all the static data.';

    /**
     * @var DDragonDataApi
     */
    protected $ddragonApi;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DDragonDataApi $ddragonApi)
    {
        parent::__construct();

        $this->ddragonApi = $ddragonApi;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = [
            'champions' => $this->ddragonApi->getChampions(),
            'runes' => $this->ddragonApi->getRunes(),
            'profileicons' => $this->ddragonApi->getProfileIcons(),
            'items' => $this->ddragonApi->getItems(),
            'maps' => $this->ddragonApi->getMaps(),
            'summoners' => $this->ddragonApi->getSummonerSpells()
        ];

        // TODO: write all data into database (optional)
        foreach ($data as $key => $item) {
            Storage::disk('public')->put($key . '.json', json_encode($item));
        }
    }
}
