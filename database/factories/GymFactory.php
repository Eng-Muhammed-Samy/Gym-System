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
        $users_id=User::where('role','=','gym_manager')->pluck('id')->toArray();
        if(!$users_id)
        {
            $user_id=User::factory()->create(['role'=>'gym_manager'])->id;
        }else{
            $user_id=$this->faker->randomElement($users_id);
        }

        return [
            'name' => $this->faker->company,
            'gym_manager_id' => $user_id,
            'city' => $this->faker->city,
        ];
    }
}
