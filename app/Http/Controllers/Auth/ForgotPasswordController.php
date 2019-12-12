<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
