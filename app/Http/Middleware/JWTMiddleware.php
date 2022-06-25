<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;




class JWTMiddleware extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, ...$guards)
    {
        $message = '';
        if($guards != null){
            foreach ($guards as $guard) {
                if ($this->auth->guard($guard)->check()) {
                    return $this->auth->shouldUse($guard);
                }
            }
            try {
              //  $user = $this->auth->authenticate($request);  //check authenticted user
                JWTAuth::parseToken()->authenticate();
                return $next($request);
            }  catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                // do whatever you want to do if a token is expired
                $message = 'token expired';
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                // do whatever you want to do if a token is invalid
                $message = 'invalid token';
            } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
                // do whatever you want to do if a token is not present
                $message = 'provide token';
            }

        }
        return response()->json([
            'success' => false,
            'message' => $message
      ]);
    }
/*
    public function handle($request, Closure $next, ...$guards)
    {
        $message = '';

        try {
            // checks token validations
            JWTAuth::parseToken()->authenticate();
            return $next($request);

      } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
          // do whatever you want to do if a token is expired
          $message = 'token expired';
      } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
          // do whatever you want to do if a token is invalid
          $message = 'invalid token';
      } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
          // do whatever you want to do if a token is not present
          $message = 'provide token';
      }
      return response()->json([
              'success' => false,
              'message' => $message
        ]);
    }*/

    /*public function handle($request, Closure $next, ...$guards)
    {
        $message = '';

        try {

            $this->authenticate($request, $guards);
            return $next($request);

      } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
          // do whatever you want to do if a token is expired
          $message = 'token expired';
      } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
          // do whatever you want to do if a token is invalid
          $message = 'invalid token';
      } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
          // do whatever you want to do if a token is not present
          $message = 'provide token';
      }
      return response()->json([
              'success' => false,
              'message' => $message
        ]);
    }

    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }
    }*/
}
