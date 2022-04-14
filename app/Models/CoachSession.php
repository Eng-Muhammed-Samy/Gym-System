<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachSession extends Model
{
    use HasFactory;
    protected $table = 'coach_session';
    protected $fillable = [
        'coach_id',
        'session_id',
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function session()
    {
        return $this->belongsTo(TrainingSession::class);
    }
}
