<?php

namespace App\Exceptions;

use Exception;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Response;

interface ExceptionSeparatorInterface
{
    public function ExceptionSeparatorInterface_ModelNotFoundException($request);
    public function ExceptionSeparatorInterface_NotFoundHttpException($request);
    public function ExceptionSeparatorInterface_ProductNotBelongsToUser($request);

}

class HandlerSeparator
{

    protected $requestForSeparator;

    protected $exceptionForSeparator;

    /**
     * Constructor.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     */
    public function __construct($request, Exception $exception)
    {
        $this->requestForSeparator = $request;
        $this->exceptionForSeparator = $exception;
    }

    /**
     * Get the exception interface method as string
     *
     * @return string
     */
    protected function GetExceptionInterfaceMethod()
    {
        $ExceptionInterfaceMethod = (new ReflectionClass($this->exceptionForSeparator))->getShortName();

        $interfaceNameArray = (new ReflectionClass($this))->getInterfaceNames();

        //TODO: We are taking the first interface name and assume its what we want, maybe there is a better method?
        $interfaceName = explode('\\', $interfaceNameArray[0]);

        $ExceptionInterfaceMethod = array_pop($interfaceName).'_'.$ExceptionInterfaceMethod;

        return $ExceptionInterfaceMethod;
    }

    /**
     * Call the exception interface method.
     *
     * @return \Illuminate\Http\Response
     */
    protected function callExceptionRenderer()
    {
        $method = $this->GetExceptionInterfaceMethod();
        return $this->$method($this->requestForSeparator);
    }

    /**
     * Check if HandlerSeparator can handle the rendering
     *
     * @return boolean
     */
    public function CanHandle()
    {
        $bCanHandle = false;

        if (is_subclass_of($this, HandlerSeparator::class))
        {
            $bCanHandle = (method_exists($this, $this->GetExceptionInterfaceMethod()));
        }

        return $bCanHandle;
    }

    /**
     * Render the exception handler.
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        //Check CanHandle from self instead of child (if inherited) to make sure the method is implemented.
        if (self::CanHandle()) {
            return $this->callExceptionRenderer();
        }
        else {
            return response('', $status=Response::HTTP_NOT_FOUND);
        }
    }

}

