<?php

namespace App\Http\Controllers;

use App\Http\Resources\Product\ReviewCollection;
use App\Http\Resources\Product\ReviewResource;
use App\Model\Review;
use App\Model\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Review  $review
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
