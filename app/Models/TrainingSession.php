<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'gym_id',
        'start_time',
        'end_time',
        'session_date',
        'coach_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function coaches()
    {
        return $this->belongsToMany(Coach::class);
    }

}
