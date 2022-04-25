<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class atLeastCityManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth('sanctum')->user();
        if ($user['role'] != 'admin' && $user['role'] != 'city_manager')
            return response()->json(
                [
                    "errors" => "not authorized",
                    "statusCode" => 403
                ]
            )->setStatusCode(403);  
        return $next($request);
    }
}
