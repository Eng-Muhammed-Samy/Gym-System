<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachesSessions extends Model
{
    use HasFactory;

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
