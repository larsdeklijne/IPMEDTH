<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class checkToken
{
   
    public function handle($request, Closure $next)
    {
        //$token = $request->input('token');

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'token_expired'], 403);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'token_invalid'], 403);
        } catch (JWTException $e) {
            return response()->json(['error' => 'token_absent'], 403);
        }

        return $next($request);
    }
}
