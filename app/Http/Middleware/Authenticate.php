<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

/*  Aaron
 *  NOTE1:  We need to override handle so that we can save guards and redirect to appropriate route
 *          if the guard is Admin or user.
 */
class Authenticate extends Middleware
{

    protected $guards = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;

        //Aaron - We just need to save the guard, the rest we still let the parent to handle this method
        return parent::handle($request, $next, ...$guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            switch (array_first($this->guards)) {
                case "admin":
                    return route('admin.login');
                    break;

                default:
                    return route('login');
                    break;
            }
        }
    }
}
