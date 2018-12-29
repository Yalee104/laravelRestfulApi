<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

/* Aaron
    NOTE:   This file is generated by executing the artisan command
            'php artisan make:resource ProductCollection'
            Please note that there are 2 types of reources, one is ResourceCollection and the 
            other is simply Resource. Here we are creating ResourceCollection
            For detail information refer to https://laravel.com/docs/5.7/eloquent-resources
*/

class ProductCollection extends ResourceCollection
{
    /* Aaron
        NOTE1:  Collection is a plural of resource in this case 'Product', however, since we named
                our resource as 'ProductResourceCustomForCollect' we will have to explicitly override it as shown below.
                We dont need to override if we named our resource simply as 'Product.php'.
        NOTE2:  You can see that we have 2 Product resources, one is called ProductResource while the other one is called
                ProductResourceCustomForCollect, the later one is used for collection since we would like to
                show the data from resource in a collection differently.
    */
    public $collects = 'App\Http\Resources\Product\ProductResourceCustomForCollect';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /* Aaron
            NOTE: The collection is from ProductResourceCustomForCollect.php of the transformed data!.
        */
        return [
            'data' => $this->collection,
            //'Other Meta' => 'Other Meta Data if needed'
            //Note that pagination 'link' and 'meta' will automatically added in the response if the request contain pagination (see ProductCOntroller.php)
        ];
        
    }
}
