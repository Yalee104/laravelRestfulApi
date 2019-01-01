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
    Route::apiResource('/products/{product}/reviews', 'ReviewController');
}
else{
    Route::group(['prefix' => 'product'], function(){

        /* Aaron
         *  NOTE:   This commit we are changing it back to original, both product and review does actually
         *          passed into the controller but we will need to match the number of input from request and
         *          provide/describe the type of the parameter. Please see the ReviewController.php difference in this changes.
         */
        Route::apiResource('/{product}/reviews', 'ReviewController');
    });
}
