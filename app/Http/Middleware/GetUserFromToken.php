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
        $access_token = $request->header('access_token');
        if (empty($access_token)) {
            return response()->json(['message' => 'access_token not found.', 'code' => 401], 401);
        }

        //kiem tra token co ton tai hay khong
        \Redis::class;

        return $next($request);
    }
}
