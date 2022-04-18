<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeOperation extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_member_id',
        'package_id',
        'gym_id',
        'paid_amount',
    ];

    public function gymmember()
    {
        return $this->belongsTo(User::class)->where('role', '=', 'gym_member');
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

}
