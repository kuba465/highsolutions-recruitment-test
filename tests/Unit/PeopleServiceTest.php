<?php

namespace Tests\Unit;

use App\Http\Models\Person;
use App\Http\Services\Swapi\PeopleService;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionException;
use Tests\TestCase;

class PeopleServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @throws ReflectionException
     */
    public function get_people_method_should_modify_people_variable()
    {
        $peopleService = new PeopleService();
        $getPeopleMethod = $this->getMethod($peopleService, 'getPeople');
        $people = [];
        $getPeopleMethod->invokeArgs($peopleService, [
            new Client(),
            PeopleService::URI,
            &$people
        ]);

        $this->assertNotEmpty($people);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function after_fetch_people_people_variable_should_contains_all_people_from_swapi_api()
    {
        $peopleService = new PeopleService();
        $fetchPeopleMethod = $this->getMethod($peopleService, 'fetchPeople');
        $people = $fetchPeopleMethod->invokeArgs($peopleService, []);

        $client = new Client();
        $response = $client->request('get', PeopleService::URI);
        $decoded = json_decode($response->getBody(), true);
        $count = $decoded['count'];

        $this->assertEquals(count($people), $count);
        return $count;
    }

    /**
     * @test
     * @depends after_fetch_people_people_variable_should_contains_all_people_from_swapi_api
     * @param int $count
     */
    public function datatable_should_contains_all_people_from_api(int $count)
    {
        $peopleService = new PeopleService();
        $peopleService->savePeople();

        $this->assertEquals(Person::all()->count(), $count);

    }
}