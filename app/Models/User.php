<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

   /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function gym_member() // one to one realationship with user
    {
        return $this->hasOne(Gym_Member::class, 'user_id');
    }
    /**
     * Get the user's avatar image.
     *
     * @return string
     */
    public function getAvatarImageAttribute($value)
    {
        return asset('avatars/'.$value);
    }
    public function Ban()
    {
        return $this->hasOne(Ban::class);
    }
    public function getRole()
    {
        if($this->role == 'city_manager')
            return $this->hasOne(CityManager::class, 'user_id');
        elseif($this->role == 'gym_manager')
            return $this->hasOne(GymManager::class, 'user_id');
        elseif($this->role == 'gym_member')
            return $this->hasOne(Gym_Member::class, 'user_id');
        else
            return null;       
    }
}
