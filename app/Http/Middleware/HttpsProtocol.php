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
        var_dump($request->getUri());
        var_dump(app()->environment('local'));
        dd(starts_with($request->getUri(), 'http') && !app()->environment('local'));

        if (starts_with($request->getUri(), 'http') && !app()->environment('local')) {
            //$request->setTrustedProxies( [ $request->getClientIp() ] );

            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
