<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Referral;
use App\Mail\ReferralInvitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReferralTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_should_create_referrals()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = [
            'emails' => [
                $this->faker->safeEmail,
                $this->faker->safeEmail,
                $this->faker->safeEmail,
                $this->faker->safeEmail,
                $this->faker->safeEmail,
            ],
            'referrer_id' => $user->id
        ];

        Mail::fake();

        $response = $this->post('/api/referrals/invite', $payload);

        $response->assertStatus(200);
        $this->assertDatabaseHas('referrals', [
            'email' => $payload['emails'][0],
            'referrer_id' => $user->id
        ]);

        Mail::send(ReferralInvitation::class);
        Mail::assertSent(ReferralInvitation::class);
    }

    /**
     * Test if user can send referral if he or she have already 10 successfull referrals
     * 
     * @return void
     */
    public function test_it_should_not_create_referrals_if_have_ten_successfull_referrals()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $refferals = Referral::factory(10)->registered()->create(['referrer_id' => $user->id]);

        $payload = [
            'emails' => [
                $this->faker->safeEmail,
                $this->faker->safeEmail,
                $this->faker->safeEmail,
                $this->faker->safeEmail,
                $this->faker->safeEmail,
            ],
            'referrer_id' => $user->id
        ];

        $response = $this->post('/api/referrals/invite', $payload);

        $response->assertStatus(422);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_should_display_my_referrals()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/api/referrals/me');
        $response->assertOk();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_should_display_all_referrals()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/api/referrals');
        $response->assertOk();
    }
}
