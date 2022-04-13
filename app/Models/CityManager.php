<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityManager extends Model
{
    use HasFactory;
    protected $fillable=['user_id','city_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function gyms()
    {
        return $this->hasMany('App\Models\Gym');
    }
}
