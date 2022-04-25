<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityManager extends Model
{
    use HasFactory; 
    protected $fillable=['user_id'];
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
    public function city()
    {
        return $this->hasOne(City::class,'city_manager_id','id');
    }

    // public function gyms()
    // {
    //     return $this->hasMany(Gym::class);
    // }
}
