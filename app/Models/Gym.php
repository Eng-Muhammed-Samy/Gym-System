<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        // 'address',
        'city',
        // 'state',
        // 'zip',
        // 'phone',
        // 'email',
        // 'website',
        // 'logo',
        // 'description',
        // 'user_id',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function training_sessions()
    {
        return $this->hasMany(TrainingSession::class);
    }
}
