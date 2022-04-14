<?php

namespace App\Http\Resources\Gym_Members;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GymMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [

            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'avatar_image' => $this->user->avatar_image,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),

        ];
    }
}
