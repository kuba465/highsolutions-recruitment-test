<?php

namespace Tests\Unit\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerifyTokenMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_return_404_when_no_token_in_url()
    {
        $response = $this->get(route('get_people'));

        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function should_return_404_when_wrong_token_in_url()
    {
        $response = $this->get(route('get_people', [
            'token' => 'xxx'
        ]));

        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function should_pass_when_correct_token_provided_in_url()
    {
        $token = config('app.api_token');
        $response = $this->get(route('get_people', [
            'token' => $token
        ]));

        $this->assertEquals(200, $response->getStatusCode());
    }
}