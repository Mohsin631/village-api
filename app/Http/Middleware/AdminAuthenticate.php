<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (!Auth::user()->is_admin) {
            Auth::logout();
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
