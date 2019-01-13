<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class ApiHandler extends HandlerSeparator implements ExceptionSeparatorInterface
{
    /* Overrides */

    /**
     * Check if HandlerSeparator can handle the rendering
     *
     * @return boolean
     */
    public function CanHandle()
    {
        $bCanHandle = false;

        //make sure we first check from the parent class if we can handle the exception request
        if (parent::CanHandle()) {
            if ($this->requestForSeparator->expectsJson()) {
                $bCanHandle = true;
            }
        }

        return $bCanHandle;
    }

    /* Interface Implementations */

    /**
     * ModelNotFoundException Render for ApiHandler
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function ExceptionSeparatorInterface_ModelNotFoundException($request, $exception)
    {
        return response()->json([
            'error' => 'Product/Review Model Not Found'
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * NotFoundHttpException Render for ApiHandler
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function ExceptionSeparatorInterface_NotFoundHttpException($request,$exception)
    {
        return response()->json([
            'error' => 'Incorrect Route'
        ], Response::HTTP_NOT_FOUND);
    }


    /**
     * ProductNotBelongsToUser Render for ApiHandler
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function ExceptionSeparatorInterface_ProductNotBelongsToUser($request,$exception)
    {
        return response()->json([
            'error' => 'Product not belong to user'
        ], Response::HTTP_UNAUTHORIZED);
    }


    /**
     * ReviewNotBelongToProduct Render for ApiHandler
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function ExceptionSeparatorInterface_ReviewNotBelongToProduct($request,$exception)
    {
        return response()->json([
            'error' => 'This review does not belong to the specified product'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * ThrottleRequestsException Render for ApiHandler
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function ExceptionSeparatorInterface_ThrottleRequestsException($request,$exception)
    {
        return response()->json([
        'error' => 'Maximum API attempt reached!'
        ], Response::HTTP_BAD_REQUEST);
    }

}
