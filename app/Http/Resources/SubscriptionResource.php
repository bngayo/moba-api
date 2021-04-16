<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'begins_at' => $this->begins_at,
            'expires_at' => $this->expires_at,
            'subscription_plan' => $this->subscription_plan->description
        ];
    }
}
