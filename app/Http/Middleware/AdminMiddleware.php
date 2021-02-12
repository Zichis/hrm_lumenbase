<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (!in_array('ROLE_ADMIN', $user->rolesNames())) {
            return response()->json(["message" => "Not authorized!"], 401);
        }
        
        return $next($request);
    }
}
