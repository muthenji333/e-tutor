<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Support\Facades\Auth;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
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
        $this->middleware('auth');
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
