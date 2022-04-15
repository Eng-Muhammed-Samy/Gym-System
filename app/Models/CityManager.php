<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityManager extends Model
{
    use HasFactory;
    // protected $table = 'city_managers'; 
    protected $fillable=['user_id','city_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->hasOne(City::class);
    }

    public function gyms()
    {
        return $this->hasMany(Gym::class);
    }
}
