<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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

            'customer' => $this->customer,
            'description' => $this->review,
            'rating' => $this->star,
            'href' => [
                'product' => route('products.show', $this->product_id)
            ]
        ];

    }
}
