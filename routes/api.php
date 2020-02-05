<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'namespace' => 'Swapi',
    'name' => 'swapi.',
    'middleware' => ['verify-token']
], function () {
    Route::get('fetch-people', 'PeopleController@fetchPeopleAction')
        ->name('fetch_people');

    Route::group([
        'middleware' => 'not-empty-swapi-table',
        'prefix' => 'get-people'
    ], function () {
        Route::get('/', 'PeopleController@getPeopleAction')
            ->name('get_people');

        Route::get('/{name}', 'PeopleController@getPersonAction')
            ->name('get_person')
            ->middleware(['check-name']);
    });
});
