<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

/* Aaron
    NOTE:   This file is generated by executing the artisan command
            'php artisan make:resource ProductResource'
            Please note that there are 2 types of reources, one is ResourceCollection and the 
            other is simply Resource. Here we are creating Resource (or JsonResource)
            For detail information refer to https://laravel.com/docs/5.7/eloquent-resources
*/

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /* Aaron
            NOTE:   Here we are translating the request response data to return only the data
                    we want to show to the user/client.
        */
        return [
            'name' => $this->name,
            'description' => $this->detail,
            'price' => $this->price,
            'stock' => $this->stock == 0 ? 'Out Of Stock' : $this->stock,
            'discount' => $this->discount,
            'totalPrice' => round((1 - ($this->discount/100)) * $this->price, 2),
            'rating' => $this->reviews->count() > 0 ? round(($this->reviews->sum('star')/$this->reviews->count()), $precision = 1) : 'No Rating(s) Yet',
            'href' => [
                'reviews' => route('reviews.index', $this->id)
            ]
        ];
    }
}
