<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_should_authenticated_successfully()
    {
        $user = User::factory()->create();
        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertStatus(200);
    }

     /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_should_not_login_empty_payload()
    {
        $response = $this->post('/api/auth/login', [
            'email' => '',
            'password' => ''
        ]);
        $response->assertStatus(422);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_should_not_login_wrong_credentials()
    {
        $response = $this->post('/api/auth/login', [
            'email' => $this->faker->safeEmail(),
            'password' => 'test'
        ]);
        $response->assertStatus(401);
        $response->assertUnauthorized();
    }
}
