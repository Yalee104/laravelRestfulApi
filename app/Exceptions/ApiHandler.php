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

        if ($this->requestForSeparator->expectsJson())
        {
            $bCanHandle = true;
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
    public function ExceptionSeparatorInterface_ModelNotFoundException($request)
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
    public function ExceptionSeparatorInterface_NotFoundHttpException($request)
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
    public function ExceptionSeparatorInterface_ProductNotBelongsToUser($request)
    {
        return response()->json([
            'error' => 'Product not belong to user'
        ], Response::HTTP_UNAUTHORIZED);
    }


}
