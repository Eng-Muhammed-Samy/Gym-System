<?php

namespace App\Models;

use Carbon\Carbon;
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
    ];
    public function toArray(){
        return [
            'id'=>$this->id,
            'name'=> $this->name,
            'gym_id'=> $this->gym_id,
            'start_time'=> Carbon::parse($this->start_time)->format('h:i:s'),
            'end_time'=> Carbon::parse($this->end_time)->format('h:i:s'),
            'attendance'=>$this->attendance,
            'session_date'=> Carbon::parse($this->session_date)->format('Y-m-d'),
            'coaches'=> $this->coaches->pluck('name')->toArray(),
        ];
    }

    public function gym(){
        return $this->belongsTo(Gym::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'attendances','training_session_id','user_id');
    }

    public function coaches()
    {
        return $this->belongsToMany(Coach::class,'coach_session','session_id','coach_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class,'training_session_id');
    }

    public function getOverlabingSessions(){
        $overlappingSessions = TrainingSession::where('gym_id',$this->gym_id)
            ->where('start_time','<',$this->end_time)
            ->where('end_time','>',$this->start_time)
            ->where('session_date',$this->session_date)
            ->get();
        return $overlappingSessions;
    }

    public function isActive(){
        $now = Carbon::now();
        $startTime = Carbon::parse($this->start_time);
        $endTime = Carbon::parse($this->end_time);
        if($this->session_date >= $now->format('Y-m-d') && $now->between($startTime,$endTime) ){
            return true;
        }
        return false;
    }

}
