<?php

namespace Tests\Unit\Middleware;

use App\Http\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotEmptySwapiTableMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_return_empty_table_response_when_no_people_in_table()
    {
        $token = config('app.api_token');
        $response = $this->get(route('get_people', [
            'token' => $token
        ]));

        $this->assertEquals(__('swapi.empty_table'), $response->getContent());
    }

    /**
     * @test
     */
    public function should_pass_when_few_elements_exists_in_table()
    {
        factory(Person::class, 3)->create();

        $token = config('app.api_token');
        $response = $this->get(route('get_people', [
            'token' => $token
        ]));

        $this->assertEquals(200, $response->getStatusCode());
    }
}