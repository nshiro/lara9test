<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PostShowLimit
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
        if ($this->runningUnitTests()) {
            return $next($request);
        }

        if (! in_array($request->ip(), ['192.168.255.255'], true)) {
            abort(403, 'Your IP is not valid.');
        }

        return $next($request);
    }

    protected function runningUnitTests()
    {
        return app()->runningInConsole() && app()->runningUnitTests();
    }
}
