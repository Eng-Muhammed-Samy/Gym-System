<?php

namespace Database\Factories;

use App\Models\CityManager;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $managers_id=CityManager::all()->pluck('id')->toArray();
        return [
            "name" => $this->faker->unique()->city,
            'city_manager_id' => $managers_id ? $this->faker->randomElement($managers_id) : CityManager::factory()->create()->id,
        ];
    }
}
