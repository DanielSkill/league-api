<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Support\DDragonAPI\DDragonDataApi;
use Illuminate\Support\Facades\Storage;
use App\Services\PersistDataService;

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
     * @var PersistDataService
     */
    protected $persistDataService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DDragonDataApi $ddragonApi, PersistDataService $persistDataService)
    {
        parent::__construct();

        $this->ddragonApi = $ddragonApi;
        $this->persistDataService = $persistDataService;
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
            'championsFull' => $this->ddragonApi->getChampions(true),
            'runes' => $this->ddragonApi->getRunes(),
            'profileicons' => $this->ddragonApi->getProfileIcons(),
            'items' => $this->ddragonApi->getItems(),
            'maps' => $this->ddragonApi->getMaps(),
            'summoners' => $this->ddragonApi->getSummonerSpells()
        ];

        $this->persistDataService->saveChampionsData($data['championsFull']);

        // TODO: write all data into database (optional)
        foreach ($data as $key => $item) {
            Storage::disk('public')->put($key . '.json', json_encode($item));
        }
    }
}
