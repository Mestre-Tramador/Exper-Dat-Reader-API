<?php

namespace App\Http\Middleware;

use Closure;

class APIMiddleware
{
    /**
     * Check if the requested path is not an API,
     * for so redirect it.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * The current path of the request.
         *
         * @var string
         */
        $path = $request->path();

        if(preg_match('/^(api\b)/', $path))
        {
            if(array_key_exists($request->getMethod().$request->getPathInfo(), app()->router->getRoutes()))
            {
                return $next($request);
            }
        }

        if($path !== '/')
        {
            return redirect('/');
        }

        return $next($request);
    }
}
