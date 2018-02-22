<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class LazyLoading
{
    /**
     * Cache a request via lazy loading.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if (Redis::exists($request->path())) {
            return unserialize(Redis::get($request->path()));
        } else {
            $response = $next($request);
            Redis::set($request->path(),serialize($response));
            Redis::expire($request->path(), 15 * 60);
            return $response;
        }
    }
}
