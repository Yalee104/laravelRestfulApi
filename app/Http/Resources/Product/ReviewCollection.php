<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends ResourceCollection
{

    public $collects = 'App\Http\Resources\Product\ReviewResource';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            //'Other Meta' => 'Other Meta Data if needed'
            //Note that pagination 'link' and 'meta' will automatically added in the response if the request contain pagination (see ProductCOntroller.php)
        ];
        //return parent::toArray($request);
    }
}
