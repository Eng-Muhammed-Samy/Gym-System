<?php

namespace App\Models;

use App\Http\Resources\CityManagerResource\CityManagerResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'city_manager_id',
    ];

    public function cityManager()
    {
        return $this->belongsTo(CityManager::class);
    }
    public function gyms()
    {
        return $this->hasMany(Gym::class);
    }
    public function toArray(){
        return ['id' => $this->id,
        'name' => $this->name,
        'city_manager' =>$this->cityManager?$this->cityManager->user:null,
        'gyms' => $this->gyms,
        'created_at' => $this->created_at->format('Y-m-d'),
        'updated_at' => $this->updated_at->format('Y-m-d'),
    ];
        
    }
}
