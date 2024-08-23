<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (auth()->user()->hasRole('administrator')) {
                    return redirect()->route('administrator.dashboard');
                } else if (auth()->user()->hasRole('employee')) {
                    return redirect()->route('employee.dashboard');
                } else if (auth()->user()->hasRole('finance')) {
                    return redirect()->route('finance.dashboard');
                } else if (auth()->user()->hasRole('hrd')) {
                    return redirect()->route('hrd.dashboard');
                } else if (auth()->user()->hasRole('director')) {
                    return redirect()->route('director.dashboard');
                }
            }
        }

        return $next($request);
    }
}
