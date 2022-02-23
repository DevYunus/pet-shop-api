<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->user,
            'order_status' => $this->orderStatus,
            'payment' => $this->payment,
            'uuid' => $this->uuid,
            'products' => ProductResource::collection($this->products),
            'address' => $this->address,
            'delivery_fee' => $this->delivery_fee,
            'amount' => $this->amount,
            'shipped_at' => $this->shipped_at,
        ];
    }
}
