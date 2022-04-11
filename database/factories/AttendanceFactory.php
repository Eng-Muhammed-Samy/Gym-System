<?php

namespace Database\Factories;

use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $trainingSession=TrainingSession::all()->pluck('id')->toArray();
        $users=User::where('role','=','user')->pluck('id')->toArray();
        return [
            'traning_session_id' => $this->faker->randomElement($trainingSession),
            'user_id' => $this->faker->randomElement($users),
            'attendance_time' => $this->faker->time(),
            'attendance_date' => $this->faker->date(),    
        ];
    }
}
