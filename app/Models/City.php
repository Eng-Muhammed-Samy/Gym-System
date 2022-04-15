<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'city_manager_id',
    ];

    public function city_manager()
    {
        return $this->belongsTo(CityManager::class);
    }

    public function gyms()
    {
        return $this->hasMany(Gym::class);
    }
    public function toArray(){
        $array = parent::toArray();
        $array['city_manager'] = $this->city_manager;
        $array['gyms'] = $this->gyms;
        return $array;
    }
}
