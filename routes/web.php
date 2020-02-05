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

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'namespace' => 'Swapi',
    'name' => 'swapi.',
    'middleware' => 'verify-token'
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
