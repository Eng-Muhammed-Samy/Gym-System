<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ban>
 */
class BanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users=User::where('role','user')->orWhere('role','gym_manager')->get()->pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($users),
            'reason' => $this->faker->sentence,
        ];
    }
}
