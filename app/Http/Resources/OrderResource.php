<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this?->user->name,
            'user_email' => $this?->user->email,
            'order_date' => $this->order_date,
            'phone' => $this->phone,
            'lng' => $this->lng,
            'lat' => $this->lat,
            'products' => $this->whenLoaded('products', ProductResource::collection($this->products)),
            'total' => $this->total,
            'created_at' => $this->created_at
        ];
    }
}
