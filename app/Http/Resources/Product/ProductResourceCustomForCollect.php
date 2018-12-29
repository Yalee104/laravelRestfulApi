<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResourceCustomForCollect extends JsonResource
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
            'name' => $this->name,
            'description' => $this->detail,
            'totalPrice' => round((1 - ($this->discount/100)) * $this->price, 2),
            'rating' => $this->reviews->count() > 0 ? round(($this->reviews->sum('star')/$this->reviews->count()), $precision = 1) : 'No Rating(s) Yet',
            'href' => [
                'link' => route('products.show', $this->id)
            ]
        ];
    }
}
