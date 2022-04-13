<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Ban;
use App\Models\Coach;
use App\Models\Gym;
use App\Models\Package;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(30)->create();
        Coach::factory(10)->create();
        Gym::factory(10)->create();
        Ban::factory(10)->create();
        TrainingSession::factory(10)->create();
        Package::factory(10)->create();
        Attendance::factory(10)->create();
    }
}
