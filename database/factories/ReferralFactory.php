<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Referral;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReferralFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Referral::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->safeEmail,
            'referrer_id' => User::factory(),
            'status' => 'invited',
            'code' => Str::random(40)
        ];
    }

    public function invited()
    {
        return $this->state(function() {
            return [
                'status' => 'invited'
            ];
        });
    }


    public function registered()
    {
        return $this->state(function() {
            return [
                'status' => 'registered'
            ];
        });
    }
}
