<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckPermission
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
        $route = Route::getCurrentRoute();
        $user = auth()->user();
        if (!empty($user)) {
            if($user->hasRole('administrator') || $user->hasAnyPermission($route->getName())) return $next($request);
            return response()->json([
                'message' => 'You are not allowed to do this',
            ], 403);
        } else {
            return response()->json([
                'message' => 'USER IS NOT LOGGED IN',
            ], 401);
        }
    }
}
