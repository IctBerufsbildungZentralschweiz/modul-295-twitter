<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class F6Test extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_endpoint_get_logout_returns_200_on_logout_success(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson('/api/logout');

        $response->assertStatus(200);

        $response->assertJsonStructure(['message']);
    }

    public function test_endpoint_get_logout_returns_200_on_logout_fail(): void
    {
        $response = $this->postJson('/api/logout');
        $response->assertStatus(401);
    }

    public function test_endpoint_get_logout_returns_401_with_logged_out_user(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $this->postJson('/api/logout');

        $this->app->get('auth')->forgetGuards();

        $response = $this->getJson('/api/auth');
        $response->assertStatus(401);
    }


}
