<?php

namespace Tests\Feature;

use App\Http\Models\Person;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PeopleControllerTest extends TestCase
{
    use RefreshDatabase;

    public $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->token = config('app.api_token');
    }

    /**
     * @test
     */
    public function database_should_contains_people_and_response_ok()
    {
        $response = $this->get(route('fetch_people', [
            'token' => $this->token
        ]));
        $people = Person::all();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(__('swapi.people_saved'), $response->getContent());
        $this->assertTrue($people->count() > 0);
        return $people;
    }

    /**
     * @test
     * @depends database_should_contains_people_and_response_ok
     * @param Collection $people
     */
    public function get_people_should_return_all_people(Collection $people)
    {
        $mapped = $this->getMappedPeople($people);
        DB::table('swapi_people')->insert($mapped);

        $response = $this->get(route('get_people', [
            'token' => $this->token
        ]));

        $this->assertSame($people->toJson(), $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @depends database_should_contains_people_and_response_ok
     * @param Collection $people
     */
    public function get_people_with_name_none_existing_in_database_should_404_response(Collection $people)
    {
        $mapped = $this->getMappedPeople($people);
        DB::table('swapi_people')->insert($mapped);

        $response = $this->get(route('get_person', [
            'name' => 'not_exists',
            'token' => $this->token
        ]));

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(__('swapi.not_found'), $response->getContent());
    }

    /**
     * @test
     * @depends database_should_contains_people_and_response_ok
     * @param Collection $people
     */
    public function get_people_with_name_existing_in_database_should_return_object_and_200_response(Collection $people)
    {
        $mapped = $this->getMappedPeople($people);
        DB::table('swapi_people')->insert($mapped);

        $response = $this->get(route('get_person', [
            'name' => 'luke_skywalker',
            'token' => $this->token
        ]));

        $luke = Person::query()->where('name', 'Luke Skywalker')->first();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertSame($luke->toJson(), $response->getContent());
    }

    /**
     * @param Collection $people
     * @return array
     */
    private function getMappedPeople(Collection $people): array
    {
        return $people->map(function ($person) {
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
    }
}