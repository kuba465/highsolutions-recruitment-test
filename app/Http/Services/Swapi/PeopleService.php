<?php

namespace App\Http\Services\Swapi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

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
        $decoded = json_decode($response->getBody());
        $people = array_merge($people, $decoded->results);
        if (!empty($decoded->next)) {
            $this->getPeople($client, $decoded->next, $people);
        }
    }
}
