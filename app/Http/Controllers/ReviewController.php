<?php

namespace App\Http\Controllers;

use App\Exceptions\ReviewNotBelongToProduct;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\Product\ReviewCollection;
use App\Http\Resources\Product\ReviewResource;
use App\Model\Review;
use App\Model\Product;
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
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request, Product $product)
    {
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
