<?php

namespace Tests\Feature;

use Tests\TestCase;


class F1Test extends TestCase
{
    public function test_endpoint_get_login_returns_405(): void
    {
        $response = $this->get('/api/login');

        $response->assertStatus(405);
    }

    public function test_endpoint_post_login_returns_422_without_valid_credentials(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => '',
            'password' => ''
        ]);

        $response->assertStatus(422);
    }
}
