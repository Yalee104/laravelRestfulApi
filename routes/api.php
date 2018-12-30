<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* Aaron
    NOTE:   The difference between Route::Resource and Route::apiResource is that Resource will create all methods
            while apiResource will create most method except the product.create and product.edit which we 
            will not be needing it for RESTful API.
            To see the difference simply change below to Resource or apiResource and use terminal and list the route by "php artisan route:list"
*/
Route::apiResource('/products', 'ProductController');

/* Aaron
    NOTE:   Below are equivalent but group allows you to share route attributes such as middleware, etc.. in case its needed
            Its more convinient using group.
*/
if(0){
    Route::apiResource('/products/{product}/reviews', 'ReviewController')->parameters(['reviews' => 'reviewindex']);
}
else{
    Route::group(['prefix' => 'product'], function(){

        /* Aaron
         *  NOTE:   The parameters function overrides the default parameter names, in this case
         *          we don't want the parameter named as  api/product/{product}/reviews/{review} because
         *          {review} is no the review database id, instead its the index of the product's reviews.
         *          Therefore by overriding it as shown below we can obtain  api/product/{product}/reviews/{reviewindex}
         */
        Route::apiResource('/{product}/reviews', 'ReviewController')->parameters(['reviews' => 'reviewindex']);
    });
}
