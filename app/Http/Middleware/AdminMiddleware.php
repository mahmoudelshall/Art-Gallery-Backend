<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) :Response
    {
        // if ($request->user()->role !== 'admin') {
        //     return response()->json(['message' => 'Access denied'], 403); // 'Forbidden
        // }
        $user = $request->user();

    if ($user !== null) {
        $roles = $user->roles;
        if ($roles !== 'admin') {
                 return response()->json(['message' => 'Access denied'], 403); // 'Forbidden
             }
    } else {
        // Handle the case when the user is not authenticated or the object is null
    }
      
        return $next($request);
    }
}
