<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        /*  AARON
         *  NOTE1:  We override authenticated method to route to the location that we intent to otherwise,
         *          redirect()->intended($this->redirectPath() will be called from trait AuthenticatesUsers's
         *          sendLoginResponse method which will check if there is intended url, if so it will be routed to there instead of
         *          our $$redirectTo.
         *  NOTE2:  The intended url mentioned in NOTE1 is url that is saved in session by laravel which is saved on every re-route
         *          and when log-in success it will be the primary routing. For example,
         *          1) First we go to eapi.test/admin
         *          2) It will be re-directed to eapi.test/admin/login and at this point the intended url will be saved as eapi.test/admin/login
         *          3) Now if we change the path to eapi.test/login which is normal user login page and we login
         *          4) We will be re-directed (after log in success) to "intended url" instead which is eapi.test/admin/login !!!, ofcourse, expected
         *             re-direct should be to eapi.test/home
         *          PS. In order to solve this issue we "override" this authenticated method so that we make sure the intended url is not used and we route to
         *              the point of interest.
         */
        return  redirect()->route('home');
    }

}
