<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'city_id',
        'city_manager_id',
    ];

    public function cityManager()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function gymManagers()
    {
        return $this->hasMany(GymManager::class);
    }
    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function training_sessions()
    {
        return $this->hasMany(TrainingSession::class);
    }
}
    