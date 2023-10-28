<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class AuthOwner
{
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = $this->auth->guard($guard)->user();
        $id = $request->id ?? $request->user_id;

        if ($user && $user->id == $id) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
