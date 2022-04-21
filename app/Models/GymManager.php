<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class GymManager extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'gym_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function toArray()
    {
        return [
            'gym_manager_id' => $this->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'avatar_image' => $this->user->avatar_image,
            'gym' => $this->gym,
            'created_at' => $this->user->created_at->format('Y-m-d'),
            'updated_at' => $this->user->updated_at->format('Y-m-d'),
        ];
    }
}
