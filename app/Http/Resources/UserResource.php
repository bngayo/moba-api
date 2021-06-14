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
            'country' => $this->country,
            'about' => $this->about,
            'house' => $this->house,
            'prefect' => $this->prefect,
            'prefect_title' => $this->prefect_title,
            'year' => $this->year_completed,
            'photo' => $this->photo,
            'deleted_at' => $this->deleted_at,
            'subscriptions' => SubscriptionResource::collection($this->whenLoaded('subscriptions')),
            'active_subscription' => new SubscriptionResource($this->whenLoaded('activeSubscription'))
        ];
    }
}
