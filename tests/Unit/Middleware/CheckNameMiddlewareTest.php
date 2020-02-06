<?php

namespace Tests\Unit\Middleware;

use App\Http\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckNameMiddlewareTest extends TestCase
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
    public function should_return_wrong_name_response_when_wrong_name_provided()
    {
        factory(Person::class, 3)->create();
        $response = $this->get(route('get_person', [
            'name' => '$',
            'token' => $this->token
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
        $response = $this->get(route('get_person', [
            'name' => $person->name,
            'token' => $this->token
        ]));

        $this->assertEquals(200, $response->getStatusCode());
    }
}