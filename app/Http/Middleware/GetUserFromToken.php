<?php

namespace App\Http\Middleware;

use Closure;

class GetUserFromToken
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
        $token = $request->header('token');
        if (empty($token)) {
            return response()->json(['message' => 'Unauthorized.', 'code' => 401], 401);
        } else {
            return $next($request);
        }
    }
}
