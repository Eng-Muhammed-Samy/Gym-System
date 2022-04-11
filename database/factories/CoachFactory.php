<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coach>
 */
class CoachFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $session=\App\Models\TrainingSession::all()->pluck('id')->toArray();
        return [
            'name'=>$this->faker->name(),
            // 'salary'=>$this->faker->randomFloat(2,1000,10000),
            // 'session_id'=>$this->faker->randomElement($sassions),
        ];
    }
}
