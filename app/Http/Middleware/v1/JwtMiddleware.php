<?php

namespace App\Http\Middleware\v1;

use App\Enums\StatusCodeEnum;
use App\Helpers\ApiResponse;
use Closure;
use Exception;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request                                                                          $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                $errors = [
                    'code' => StatusCodeEnum::TOKEN_INVALID->value,
                    'message' => StatusCodeEnum::TOKEN_INVALID->name
                ];
            } else if ($e instanceof TokenExpiredException) {
                $errors = [
                    'code' => StatusCodeEnum::TOKEN_EXPIRED->value,
                    'message' => StatusCodeEnum::TOKEN_EXPIRED->name
                ];
            }

            return ApiResponse::createFailedResponse()
                ->setError($errors)
                ->setCode(401)
                ->setMessage('AUTHENTICATION_FAILED')
                ->toApiJson();
        }
        return $next($request);
    }
}
