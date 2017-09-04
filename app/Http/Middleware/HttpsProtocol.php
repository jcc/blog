<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class HttpsProtocol
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
        Log::info('X-forwarded-Proto:'.$request->header('X-Forwarded-Proto'));
        Log::info('Uri:'.$request->getRequestUri());
        if ($request->header('X-Forwarded-Proto') == 'http' && !app()->environment('local')) {
            //$request->setTrustedProxies( [ $request->getClientIp() ] );

            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
