<?php

namespace App\Http\Services\Swapi;

use Carbon\Carbon;
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
        $decoded = json_decode($response->getBody(), true);
        foreach ($decoded['results'] as $result) {
            $people[] = [
                'name' => $result['name'],
                'height' => $result['height'],
                'mass' => $result['mass'],
                'hair_color' => $result['hair_color'],
                'skin_color' => $result['skin_color'],
                'eye_color' => $result['eye_color'],
                'birth_year' => $result['birth_year'],
                'gender' => $result['gender'],
                'homeworld' => $result['homeworld'],
                'films' => json_encode($result['films']),
                'species' => json_encode($result['species']),
                'vehicles' => json_encode($result['vehicles']),
                'starships' => json_encode($result['starships']),
                'created' => Carbon::parse($result['created']),
                'edited' => Carbon::parse($result['edited']),
                'url' => $result['url']
            ];
        }
//        $people = array_merge($people, $decoded['results']);
        if (!empty($decoded['next'])) {
            $this->getPeople($client, $decoded['next'], $people);
        }
    }
}
