<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Authenticate by HTTP Basic.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(!$request->headers->has('Authorization'))
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if
        (
            $request->headers->get('Php-Auth-User') !== env('AUTH_USER') ||
            $request->headers->get('Php-Auth-Pw')   !== env('AUTH_PW')
        )
        {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
