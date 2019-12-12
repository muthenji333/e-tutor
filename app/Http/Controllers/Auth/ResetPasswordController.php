<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
