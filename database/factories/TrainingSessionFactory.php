<?php

namespace Database\Factories;

use App\Models\Coach;
use App\Models\Gym;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Time;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainingSession>
 */
class TrainingSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //insert into training_sessions (`name`, `start_time`, `end_time`, `session_date`, `gym_id`, `coach_id`, `updated_at`, `created_at`)
        // values
        // ('dasaas','2022-04-09 20:23:33','2022-04-09 23:23:33','2022-04-09 23:23:33',
        // 2,5,'2022-04-09 23:23:33','2022-04-09 23:23:33');

        $start_time=$this->faker->dateTimeBetween('-1 Day', '+1 Day');
        $end_time=$this->faker->dateTimeInInterval($start_time, '+3 Hours');
        $gyms = Gym::all()->pluck('id')->toArray();
        $coaches = Coach::pluck('id')->toArray();
        return [
            'name' => $this->faker->unique()->word,
            'start_time' => $start_time,
            'end_time'=>$end_time,
            'session_date'=>$start_time,
            'gym_id'=>$this->faker->randomElement($gyms),
            'coach_id'=>$this->faker->randomElement($coaches),
        ];
    }
}
