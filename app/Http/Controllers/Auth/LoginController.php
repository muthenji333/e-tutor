<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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

    protected function authenticated($request, $user)
    {
        if ($user->hasRole('admin')) {
            return redirect('/admin/home');
        } elseif ($user->hasRole('staff')) {
            return redirect('/staff/home');
        } elseif ($user->hasRole('tutor')) {
            return redirect('/tutor/home');
        } elseif ($user->hasRole('tutee')) {
            return redirect('/tutee/home');
        } else {
            Auth::logout();
            return redirect('login');
        }
    }
}
