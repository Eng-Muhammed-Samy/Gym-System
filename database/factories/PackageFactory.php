<?php

namespace Database\Factories;

use App\Models\Gym;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gyms= Gym::all()->pluck('id')->toArray();
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'session_count' => $this->faker->numberBetween(1, 10),
            'gym_id' => $this->faker->randomElement($gyms),
            'discount' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
