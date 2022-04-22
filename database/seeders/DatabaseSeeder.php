<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Ban;
use App\Models\City;
use App\Models\CityManager;
use App\Models\Coach;
use App\Models\CoachSession;
use App\Models\Gym;
use App\Models\Gym_Member;
use App\Models\GymManager;
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
        Gym_Member::factory(User::where("role","user")->count())->create();
        CityManager::factory(User::where("role","city_manager")->count())->create();
        City::factory(10)->create();
        City::factory(10)->create(['city_manager_id' => null]);
        Coach::factory(10)->create();
        Gym::factory(10)->create();
        GymManager::factory(User::where("role","gym_manager")->count()/2)->create();
        GymManager::factory(User::where("role","gym_manager")->count()/2)->create(['gym_id'=>null]);
        Ban::factory(10)->create();
        TrainingSession::factory(10)->create();
        CoachSession::factory(10)->create();
        Package::factory(10)->create();
        Attendance::factory(10)->create();
    }
}
