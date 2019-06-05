<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'api'], function() {
    // Summoner routes
    Route::get('/summoner/by-name/{name}/{server?}', 'SummonerController@byName');
    Route::get('/summoner/by-summonerid/{id}/{server?}', 'SummonerController@bySummonerId');
    Route::get('/summoner/by-accountid/{id}/{server?}', 'SummonerController@byAccountId');

    Route::get('/matchlist/by-identity/{identity}', 'MatchListController@getMatchesByIdentity');

    Route::get('/profile/statistics/{identity}', 'ProfileController@getStatistics');
});
