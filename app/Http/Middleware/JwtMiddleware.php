<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json(['message' => 'Token inválido.', 'status' => false, 'statusCode' => 401]);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json(['message' => 'Token expirado', 'status' => false, 'statusCode' => 498]);
            } else {
                return response()->json(['message' => 'Token não encontrado', 'status' => false, 'statusCode' => 401]);
            }
        }
        return $next($request);
    }
}
