<?php

namespace App\Http\Services\Swapi;

use Carbon\Carbon;
use GuzzleHttp\Client;

class PeopleService
{
    const URI = 'https://swapi.co/api/people/';

    /**
     * @return array
     */
    public function fetchPeople(): array
    {
        $people = [];
        $client = new Client();
        $this->getPeople($client, self::URI, $people);
        return $people;
    }

    /**
     * @param Client $client
     * @param string $uri
     * @param array $people
     */
    private function getPeople(Client $client, string $uri, array &$people): void
    {
        $response = $client->request('get', $uri);
        $decoded = json_decode($response->getBody(), true);
        $mapped = collect($decoded['results'])->map(function ($person) {
            return collect($person)->map(function ($item, $key) {
                if (is_array($item)) {
                    $item = json_encode($item);
                }
                if (in_array($key, ['created', 'edited'])) {
                    $item = Carbon::parse($item);
                }
                return $item;
            });
        })->toArray();
        $people = array_merge($people, $mapped);
        if (!empty($decoded['next'])) {
            $this->getPeople($client, $decoded['next'], $people);
        }
    }
}
