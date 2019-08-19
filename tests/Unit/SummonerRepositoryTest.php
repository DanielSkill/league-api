<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use App\Support\LeagueAPI\APIResponse;
use App\Repositories\SummonerRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Contracts\Support\LeagueAPI\SummonerApiInterface;
use App\Models\Summoner;

class SummonerRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test when getting summoner, if summoner doesn't already exist in the database it creates summoner.
     *
     * @return void
     */
    public function testGetSummonerCreatesSummonerWhenDoesntAlreadyExist()
    {
        $stream = Psr7\stream_for('{
            "id": "81Seh9-sVWEkZmfSSbi4qg-UCo2YU8l-EDurtElYHzbLmfw",
            "accountId": "_hWPdsfZUiRkCnObQvxtZogb9sSh2llCN32ZM4kO26A2Sw",
            "puuid": "wo5fjT5pjYtLSBQ0mkS_Sd-poYD8mpmlAa7xir7HZ2RMn37TXvVhxaitCda3s2wCUcDYENVTXfk9JA",
            "name": "Syndra Jungle",
            "profileIconId": 4220,
            "revisionDate": 1566165348000,
            "summonerLevel": 187
        }');

        $response = new Response(200, ['Content-Type' => 'application/json'], $stream);

        $mockSummonerApi = Mockery::mock(SummonerApiInterface::class);

        $mockSummonerApi->allows()->server('euw1')->andReturns($mockSummonerApi);
        $mockSummonerApi->allows()->getSummonerByName('Syndra Jungle')->andReturns(new APIResponse($response));

        $mockSummonerApi->getSummonerByName('Syndra Jungle');

        $repository = new SummonerRepository($mockSummonerApi);

        $result = $repository->getSummonerByName('euw1', 'Syndra Jungle');

        $this->assertInstanceOf(Summoner::class, $result);
        $this->assertEquals('Syndra Jungle', $result->name);
        $this->assertDatabaseHas('summoners', ['name' => 'Syndra Jungle']);
    }

    public function testGetSummonerReturnsNullWhenNoSummonerFound()
    {
        $stream = Psr7\stream_for('{
            "status": {
                "message": "Data not found - summoner not found"
                "status_code": 404
            }
        }');

        $response = new Response(404, ['Content-Type' => 'application/json'], $stream);

        $mockSummonerApi = Mockery::mock(SummonerApiInterface::class);

        $mockSummonerApi->allows()->server('euw1')->andReturns($mockSummonerApi);
        $mockSummonerApi->allows()->getSummonerByName('Syndra Jungle')->andReturns(new APIResponse($response));

        $repository = new SummonerRepository($mockSummonerApi);

        $result = $repository->getSummonerByName('euw1', 'Syndra Jungle');

        $this->assertNull($result);
    }
}
