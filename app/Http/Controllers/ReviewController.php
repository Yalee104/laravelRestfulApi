<?php

namespace App\Http\Controllers;

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
    public function show(Product $product, $reviewIndex)
    {
        /*  Aaron
         *  NOTE1:  The show of review.show is  api/product/{product}/reviews/{reviewindex}
         *          where product we would like to be parsed in as model while reviewindex as
         *          index number. For this we wll need to explicitly route the model in RouteServiceProvider
         *          for product, keep in mind that by default this is route automatically by laravel but
         *          if there is "two" parameter pass in such as in this case it will simply pass in as
         *          number (product and reviewindex).
         *  NOTE2:  We could ofcourse route the reviewindex as well to map to Review Model but it willnot help in this case
         *          since the returned review is the id and not the index of review that is product's relation!.
         */
        $review = $product->reviews;
        if ($review->count() >= $reviewIndex) {
            return new ReviewResource($review[$reviewIndex]);
        }
        else {
            //TODO: We should return error message
        }
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
    public function update(Request $request, Review $review)
    {
        //NOT USED, We do not allow Review Update
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //NOT USED, We do not allow Review delete
    }
}
