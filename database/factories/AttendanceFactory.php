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
        $users_id=User::where('role','=','user')->pluck('id')->toArray();
        if(!$users_id){
            $user_id=User::factory()->create(['role'=>'user'])->id;   
        }
        else{
            $user_id=$this->faker->randomElement($users_id);
        }
        return [
            'traning_session_id' => $this->faker->randomElement($trainingSession),
            'user_id' => $user_id,
            'attendance_time' => $this->faker->time(),
            'attendance_date' => $this->faker->date(),    
        ];
    }
}
