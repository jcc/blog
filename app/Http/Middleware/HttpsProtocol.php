<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Support\Facades\Log;

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
        
        if ($request->header('X-Forwarded-Proto') != 'https' && !app()->environment('local')) {
            //$request->setTrustedProxies( [ $request->getClientIp() ] );

            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
