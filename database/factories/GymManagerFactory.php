<?php

namespace Database\Factories;

use App\Models\Gym;
use App\Models\User;
use Google\Service\CloudSearch\PushItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GymManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users = User::where('role', 'gym_manager')->get();
        $gyms = Gym::all()->pluck('id')->toArray();
        return [
            'user_id' => $users ? $this->faker->unique()->randomElement($users)->id :
                User::factory()->create(['role' => 'gym_manager'])->id,
            'gym_id' => $this->faker->randomElement($gyms),
        ];
    }

}
