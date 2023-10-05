<?php

namespace Tests\Feature;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_should_register_successfully()
    {
        $payload = [
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail(),
            "password" => 'password',
            "password_confirmation" => 'password',
        ];

        $response = $this->post('/api/auth/register', $payload);
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $payload['name'],
            'email' => $payload['email'],
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_should_register_with_referral_code()
    {
        $refferal = Referral::factory()->create();
        $payload = [
            "name" => $this->faker->name,
            "email" => $refferal->email,
            "password" => 'password',
            "password_confirmation" => 'password',
            "code" => $refferal->code
        ];

        $response = $this->post('/api/auth/register', $payload);
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $payload['name'],
            'email' => $payload['email'],
        ]);

        $this->assertDatabaseHas('referrals', [
            'email' => $payload['email'],
            'status' => 'registered'
        ]);
    }
}
