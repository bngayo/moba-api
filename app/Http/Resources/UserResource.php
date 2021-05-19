<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'member' => $this->member,
            'photo' => $this->photo,
            'deleted_at' => $this->deleted_at,
            'subscriptions' => SubscriptionResource::collection($this->whenLoaded('subscriptions')),
            'active_subscription' => new SubscriptionResource($this->whenLoaded('activeSubscription')->first())
        ];
    }
}
