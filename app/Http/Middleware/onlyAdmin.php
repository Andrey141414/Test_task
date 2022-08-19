<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class onlyAdmin
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

        $user = auth('api')->user();
        if($user->is_admin == false)
        {
            return response()->json([
                'message' => 'Is not Admin'
            ], 401);
        }
        else
        {
        return $next($request);
        }
    }
}
