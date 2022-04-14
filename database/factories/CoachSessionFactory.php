<?php

namespace Database\Factories;

use App\Models\Coach;
use App\Models\TrainingSession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CoachSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'coach_id'=>$this->faker->randomElement(Coach::all()->pluck('id')->toArray()),
            'session_id'=>$this->faker->randomElement(TrainingSession::all()->pluck('id')->toArray()),
        ];
    }
}
