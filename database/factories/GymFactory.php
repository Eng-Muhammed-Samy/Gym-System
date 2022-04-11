<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gym>
 */
class GymFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users=User::where('role','=','gym_manager')->pluck('id')->toArray();
        return [
            'name' => $this->faker->company,
            'gym_manager_id' => $this->faker->randomElement($users),
            'city' => $this->faker->city,
        ];
    }
}
