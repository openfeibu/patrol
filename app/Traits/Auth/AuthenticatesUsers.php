<?php

namespace App\Traits\Auth;

use Auth;
use Crypt;
use Illuminate\Foundation\Auth\AuthenticatesUsers as IlluminateAuthenticatesUsers;
use Mail;
use Socialite;
//use Symfony\Component\HttpFoundation\Session\Session;
use Theme;
use Illuminate\Http\Request;
use Session;

trait AuthenticatesUsers
{

    use IlluminateAuthenticatesUsers, Common {
         Common::guard insteadof IlluminateAuthenticatesUsers;
    }


    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function username()
    {
        return 'email';
    }
}
