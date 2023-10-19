<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Countries\CountryService;
use App\Services\Countries\MockCountryService;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CountryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->bind(
            CountryService::class,
            MockCountryService::class
        );
    }

    /** @test */
    public function it_returns_a_list_of_countries(): void
    {
        $redisSpy = Redis::spy();
        $redisSpy->shouldReceive('exists')->andReturn(false);

        $this->actingAs(User::factory()->make(), 'api');

        $response = $this->getJson('/api/countries');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data']);

        $countries = $response->json('data');

        $this->assertCount(2, $countries);
    }

    /** @test */
    public function it_does_not_return_a_list_of_countries_for_an_unauthenticated_user(): void
    {
        $response = $this->getJson('/api/countries');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
