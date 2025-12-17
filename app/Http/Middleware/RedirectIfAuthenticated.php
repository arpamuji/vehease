<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guard): Response
    {
        $guards = empty($guard) ? [null] : $guard;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                if ($user->isRoot() || $user->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                }
                if ($user->isManager()) {
                    return redirect()->route('manager.dashboard');
                }
                if ($user->isStaff()) {
                    return redirect()->route('staff.dashboard');
                }
            }
        }

        return $next($request);
    }
}
