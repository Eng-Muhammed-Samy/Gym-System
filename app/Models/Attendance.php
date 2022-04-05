<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'training_session_id',
        'attendance_time',
        'attendance_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function training_session()
    {
        return $this->belongsTo(TrainingSession::class);
    }
}
