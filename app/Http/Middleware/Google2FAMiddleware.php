<?php

namespace App\Http\Middleware;
 
use Closure;
use App\Support\Google2FAAuthentication;

class Google2FAMiddleware
{
    public function handle($request, Closure $next)
    {
        $authentication = app(Google2FAAuthentication::class)->boot($request);

        if ($authentication->isAuthenticated()) {
            return $next($request);
        }

        return $authentication->makeRequestOneTimePasswordResponse();
    }
}
