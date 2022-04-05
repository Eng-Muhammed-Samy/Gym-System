<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'name',
        'price',
        'discount',
        'session_count',
        // 'attendance_time',
        // 'attendance_date',
    ];

    public function traning_session()
    {
        return $this->belongsTo(TrainingSession::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}
