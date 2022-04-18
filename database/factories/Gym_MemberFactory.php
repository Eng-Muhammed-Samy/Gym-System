<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gym_Members>
 */
class Gym_MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users = User::where('role', 'user')->get();
        return [
            'user_id'=>$users?
            $this->faker->unique()->randomElement($users)->id:
            User::factory()->create(['role' => 'user'])->id,
            'gender'=>$this->faker->randomElement(['male', 'female']),
            'date_of_birth'=>$this->faker->date('Y-m-d',"yesterday"),
        ];
    }
}
