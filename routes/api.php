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
if(1){
    Route::apiResource('/products/{product}/reviews', 'ReviewController');
}
else{
    Route::group(['prefix' => 'productsaaa'], function(){

        Route::apiResource('/{product}/reviews', 'ReviewController');
    });
}
