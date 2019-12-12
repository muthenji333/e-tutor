<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = $request->user();

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

        return $next($request);
    }
}
