<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'reason'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function toArray(){
        return [
            'id' => $this->id,
            'user' => $this->user,
            'reason' => $this->reason,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
