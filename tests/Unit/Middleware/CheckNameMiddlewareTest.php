<?php

namespace Tests\Unit\Middleware;

use App\Http\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckNameMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_return_wrong_name_response_when_wrong_name_provided()
    {
        factory(Person::class, 3)->create();
        $token = config('app.api_token');
        $response = $this->get(route('get_person', [
            'name' => '$',
            'token' => $token
        ]));

        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function should_pass_when_correct_name_provided()
    {
        factory(Person::class, 3)->create();
        $person = Person::first();
        $token = config('app.api_token');
        $response = $this->get(route('get_person', [
            'name' => $person->name,
            'token' => $token
        ]));

        $this->assertEquals(200, $response->getStatusCode());
    }
}