<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->estado == 0) {
            Auth::logout();
            return redirect('/')->with('error', 'Tu cuenta no cuenta con acceso al sistema. Por favor, contacta al administrador.');
        }

        return $next($request);
    }
}






