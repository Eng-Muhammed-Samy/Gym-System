<?php

namespace App\Http\Resources\CityManagerResource;

use Illuminate\Http\Resources\Json\JsonResource;

class CityManagerResource extends JsonResource
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
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'ban'=>$this->user->Ban,
            'city'=>$this->city->name,
            'avatar_image' => $this->user->avatar_image,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
