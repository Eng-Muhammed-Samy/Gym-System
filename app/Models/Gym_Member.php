<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym_Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'gender',
        'date_of_birth',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
    public function delete()
    {
        // delete all related photos 
        $this->user()->delete();
       
        return parent::delete();
    }
}
