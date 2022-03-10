<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use JWTAuth;
use App\Traits\generalTrait;

class CheckAuth extends BaseMiddleware
{
    use generalTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if($guard != null){
            auth()->shouldUse($guard);      //To assign guard

            $token = $request->token;
            $request->token =  $token;
            $request->Authorization = 'Bearer '.$token;

            try{
                $user = JWTAuth::parseToken()->authenticate();

            }catch (TokenExpiredException $e){
                return $this->returnError('401', 'unAuthenticated User');

            }catch (JWTException $e){
                return $this->returnError('401', 'Token Invalid ' . $e->getMessage());
            }
        }

        return $next($request);
    }
}
