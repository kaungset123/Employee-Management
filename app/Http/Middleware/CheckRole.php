<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next, ...$roles ): Response
    {
        if (Auth::check() && Auth::user()->hasAnyRole($roles)) {
            // User has one of the specified roles, redirect accordingly
            switch (Auth::user()->roles->first()->name) {
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'manager':
                    return redirect('/manager/dashboard');
                case 'employee':
                    return redirect('/user/dashboard');
                case 'HR':
                    return redirect('/hr/dashboard');  
            }
        }

        return $next($request);
    }
}

