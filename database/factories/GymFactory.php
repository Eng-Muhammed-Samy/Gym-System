<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\CityManager;
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
        $CityManager = $this->faker->randomElement(CityManager::all());
        if (!$CityManager) {
            $user = User::factory()->create(['role' => 'city_manager']);
            $CityManager = CityManager::factory()->create([
                    'user_id' => $user->id,
                    'city_id' => City::factory()->create()->id
                ]);
        }
        logger($CityManager);
        return [
            'name' => $this->faker->company,
            'city_manager_id' => $CityManager['id'],
            'city_id' => $CityManager['city_id'],
        ];
    }
}
