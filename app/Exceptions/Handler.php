<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        /*  Aaron
         *  NOTE1:  Here we are adding exception handlings, below is just an example of checking if the request
         *          is expect json (eg, Accept application/json), otherwise we will return web html exception.
         *  NOTE2:  In order to find which instance of exception that it belongs to us dd($exception)
         *          to get the instance of failure scenario (it can be shown from PostMan response 'preview' window)
         */
        //dd($exception); //uncomment to show detail debug
        if ($request->expectsJson())
        {
            if ($exception instanceof ModelNotFoundException)
            {
                return response()->json([
                        'error' => 'Product Model Not Found'
                    ], Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof  NotFoundHttpException)
            {
                return response()->json([
                    'error' => 'Incorrect Route'
                ], Response::HTTP_NOT_FOUND);
            }
        }
        return parent::render($request, $exception);
    }
}
