<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Response;
use Closure;

class Cors {
    public function handle($request, Closure $next)
    {
        if($request->getMethod() === "OPTIONS") {
                return Response::make('OK', 200, [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin, Authorization'

            ]);
        }
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application')
            ->header('Access-Control-Allow-Credentials', 'true');
    }
}