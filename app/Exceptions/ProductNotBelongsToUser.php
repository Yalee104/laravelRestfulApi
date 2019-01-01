<?php

namespace App\Exceptions;

use Exception;

class ProductNotBelongsToUser extends Exception
{
    //No Implementation - We let the Handler (entry point) handles it which eventually calls our ApiHandler to respond the exception
}
