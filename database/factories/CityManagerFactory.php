<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CityManager>
 */
class CityManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users_id=User::where('role','=','city_manager')->pluck('id')->toArray();
        $cities_id=City::all()->pluck('id')->toArray();
        return [
            'user_id' => $users_id ? $this->faker->randomElement($users_id) : User::factory()->create(['role'=>'city_manager'])->id,
            'city_id' => $cities_id ? $this->faker->randomElement($users_id) : User::factory()->create(['role'=>'city_manager'])->id,
        ];
    }
}
