<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        /*  Aaron
         *  NOTE1:  Since previous commit violates SOLID principles we restructure the code
         *          to honor the principles (hopefully) by abstracting the Handler with HandlerSeparator class
         *          that checks if the class or its child can handle the exceptions and render it.
         *          In this implementation the ApiHandler class handles the API specific rendering while
         *          its parent class HandlerSeparator calls the exception that can be handled.
         */
        //dd($exception); //uncomment to show detail debug

        $Apihandler = new ApiHandler($request, $exception);
        if ($Apihandler->CanHandle())
        {
            return $Apihandler->render();
        }
        else
        {
            return parent::render($request, $exception);
        }
    }
}
