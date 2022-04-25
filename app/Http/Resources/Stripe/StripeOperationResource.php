<?php

namespace App\Http\Resources\Stripe;

use Illuminate\Http\Resources\Json\JsonResource;

class StripeOperationResource extends JsonResource
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
            "id"=> $this->id,
            "name" => $this->gymmember->name,
            "email" => $this->gymmember->email,
            "gym_name" => $this->gym->name,
            "package_name" => $this->package->name,
            "paid_amount"=>$this->paid_amount,
            "avatar_image"=>$this->gymmember->avatar_image
        ];
    }
}
