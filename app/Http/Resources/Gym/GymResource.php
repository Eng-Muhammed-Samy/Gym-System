<?php

namespace App\Http\Resources\Gym;

use Illuminate\Http\Resources\Json\JsonResource;

class GymResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'city_manager' => $this->cityManager,
            'gym_managers' => $this->gymManagers,
            'packages' => $this->packages,
            'training_sessions' => $this->training_sessions,
            'created At' => $this->created_at->diffForHumans('now'),
            'updated At' => $this->updated_at->diffForHumans('now'),
        ];

    }
}
