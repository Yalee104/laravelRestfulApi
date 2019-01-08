<?php

namespace App\Http\Controllers;

use App\Exceptions\ReviewNotBelongToProduct;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\Product\ReviewCollection;
use App\Http\Resources\Product\ReviewResource;
use App\Model\Review;
use App\Model\Product;
use App\Services\Twitter;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    /*  Aaron
     *  NOTE:   Add constructor so that we can intercept to use api authentication middleware
     *          to prevent unauthorized access
     */
    public function __construct()
    {
        /*  Aaron
         *  NOTE: Use middleware api authentication to prevent unauthorized access "except" index and show page.
         *        In this Review controller we would like log-in user to POST for review as opposed to open public.
         */
        $this->middleware('auth:api')->except('index','show');

        /*  Aaron
         *  NOTE1:  Here we demonstrate service container on binding the services which it can be injected
         *          directly from a function parameter (see store function below). Laravel will automatically resolve
         *          the parameter type by checking first if its a services, if so it will instantiate the class.
         *          Ofcourse, if it cannot be found within services then it will resolve by finding class.
         *          refer to https://laravel.com/docs/5.7/container#binding in service container section
         *  NOTE2:  The first method shown below does not provide closure which laravel will instantiate the class.
         *  NOTE3:  The second method show below within the else statement contain closure, laravel will call the
         *          closure instead and it is the closure responsibility to return the object (eg, instantiate the class).
         *
         */
        if (1) {

            app()->bind('App\Services\Twitter');

        }
        else {

            app()->bind('App\Services\Twitter', function () {

                return new Twitter('Twitter Key Given from Closure');
            });
        }

        /*  Aaron
         *  NOTE1:  This is just a demonstration of singleton and most IMPORTANTLY
         *          the use of abstract which does not need to be a class, it can be any string
         *          but it cannot be injected as shown from above implementation. Also it will most likely
         *          to need closure.
         *          This can be instantiated/called as show in the store function below.
         *  NOTE2:  This does not need to be singleton, it can be bind as well.
         */
        app()->singleton('Twitter.Singleton', function (){
            return new Twitter('Singleton Twitter Key Given from Closure');
        });

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return new ReviewCollection($product->reviews()->paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //NOT USED, We use Store instead
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Product  $product
     * @param  \App\Services\Twitter     $TwitterAcc
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request, Product $product, Twitter $TwitterAcc)
    {
        /*  Aaron
         *  NOTE:   The additional parameter Twitter is a service which we bind from the constructor,
         *          laravel will automatically instantiate base on the binding method.
         */
        $PostToTwitter = $request->input('PostTwitter'); //From the URL Parameter/Key
        if (filter_var($PostToTwitter, FILTER_VALIDATE_BOOLEAN) == true)
        {
            //TODO: We post the review to Twitter per request
            $TwitterAcc->Post();
        }

        /*  Aaron
         *  NOTE1: Just an example to show more than one way to instantiate service container.
         *  NOTE2: $SingletonTwitter is not used in this function
         */
        $SingletonTwitter = app('Twitter.Singleton');


        $reviewCreate = new Review;
        $reviewCreate->product_id = $product->id;
        $reviewCreate->customer = $product->name;
        $reviewCreate->review = $request->description;
        $reviewCreate->star = $request->rating;
        $reviewCreate->save();

        return response([
            "data" => new ReviewResource($reviewCreate)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Review $review)
    {
        /*  Aaron
         *  NOTE1:  In this commit we decided to use the id to model mapping instead of index
         */

        $this->CheckReviewBelongToProduct($product, $review);

        return new ReviewResource($review);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //NOT USED, We do not allow Review editing
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewRequest $request, Product $product, Review $review)
    {
        $this->CheckReviewBelongToProduct($product, $review);

        $review->review = $request->description;
        $review->star = $request->rating;
        $review->save();

        return new ReviewResource($review);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Review $review)
    {
        $this->CheckReviewBelongToProduct($product, $review);

        $review->delete();

        return response(null,Response::HTTP_NO_CONTENT);
    }


    public function CheckReviewBelongToProduct(Product $product, Review $review)
    {
        if ($product->id !== $review->product_id)
        {
            throw new ReviewNotBelongToProduct;
        }
    }
}
