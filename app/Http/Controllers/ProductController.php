<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
