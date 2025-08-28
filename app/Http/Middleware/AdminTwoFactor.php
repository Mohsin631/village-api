<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminTwoFactor
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->two_factor_confirmed_at) {
            if (!$request->routeIs('admin.2fa.page') && !$request->routeIs('admin.2fa.verify')) {
                session(['admin_intended' => url()->current()]);
            }
            return redirect()->route('admin.2fa.page');
        }

        if (!$user->two_factor_enabled) {
            return $next($request);
        }

        if (session('admin_2fa_passed') === true) {
            return $next($request);
        }

        $cookieName = "admin_2fa_remember_{$user->id}";
        if ($request->cookie($cookieName) === '1') {
            session(['admin_2fa_passed' => true]);
            return $next($request);
        }

        if (!$request->routeIs('admin.2fa.page') && !$request->routeIs('admin.2fa.verify')) {
            session(['admin_intended' => url()->current()]);
        }

        return redirect()->route('admin.2fa.page');
    }
}
