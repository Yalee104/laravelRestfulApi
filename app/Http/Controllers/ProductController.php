<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Requests\ProductRequest;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /*  Aaron
     *  NOTE:   Add constructor so that we can intercept to use api authentication middleware
     *          to prevent unauthorized access
     */
    public function __construct()
    {
        /*  Aaron
         *  NOTE: Use middleware api authentication to preven unauthorized access "except" index and show page.
         */
        $this->middleware('auth:api')->except('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Aaron
            NOTE:   Here we are calling the resource collection
                    and pagination (fix to 5 per page).
                    TRY IT: http://eapi.app/api/products/ and see the result
        */        
        return new ProductCollection(Product::paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //NOT USED, For API we use Store instead
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request) //Here we replace to ProductRequest type as we would like laravel to pass the request to ProductRequest first
    {
        //Create Product and save it to database
        $product = new Product;
        $product->name = $request->name;
        $product->detail = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->discount = $request->discount;
        $product->user_id = Auth::id();
        $product->save();

        //We send back the response with data we created, we want to response with the transformed data
        //from our ProductResource class
        return response([
            "data" => new ProductResource($product)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        /* Aaron
            NOTE:   Here we are calling the resource for translation of 
                    response data. See ProductResource.php for more detail
        */        
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //NOT USED, For API we use Update instead
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //Check if this updated product belongs to the user
        $this->ProductUserCheck($product);

        /*  Aaron
         *  NOTE:   Since the request from client does not contain 'detail' key because
         *          its named as 'description' for more generic naming. Therefore we will
         *          need to add detail key and copy the description value to it. Then its best to unset (remove) the
         *          'description' key.
         */
        $request['detail'] = $request->description;
        unset($request['description']);

        /*  Aaron
         *  NOTE:   We update the product base on what the user provided from the request, note that we already added
         *          fillable in the Product Model for mass assignment to prevent overwriting protected keys.
         */
        $product->update($request->all());

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //Check if this updated product belongs to the user
        $this->ProductUserCheck($product);

        $product->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }

    /**
     * Check if product belongs to user, if not throw exception
     *
     * @param  \App\Model\Product  $product
     * @return void
     */
    public function ProductUserCheck($product)
    {
        if (Auth::id() !== $product->user_id)
        {
            throw new ProductNotBelongsToUser;
        }
    }

}
