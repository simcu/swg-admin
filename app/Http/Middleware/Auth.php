<?php

namespace App\Http\Middleware;

use Closure;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session('logined')) {
            if ($request->input('ref')) {
                return redirect('/login?ref=' . $request->input('ref'));
            } else {
                return redirect('/login');

            }
        }

        return $next($request);
    }
}