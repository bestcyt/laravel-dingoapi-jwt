<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\UnauthorizedException;
use Tymon\JWTAuth\JWTAuth;

class CheckSystem
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed,JWTAuth $JWTAuth
     */
    public function handle($request,Closure $next,$system = '' )
    {

        //根据token的system参数检测不同的系统用户
        $token_system = auth()->parseToken()->getClaim('system');

        if ($token_system != $system){
            throw new UnauthorizedException('非改系统用户');
        }

        return $next($request);
    }
}
