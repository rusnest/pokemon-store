<?php

namespace App\Http\Middleware;

use App\Enums\StatusCodeEnum;
use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {

        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $this->auth->shouldUse($guard);
                return $next($request);
            }
        }

        return ApiResponse::createFailedResponse()
            ->setError(
                [
                    'code' => StatusCodeEnum::AUTHENTICATION_FAILED->value,
                    'message' => StatusCodeEnum::AUTHENTICATION_FAILED->name
                ]
            )
            ->setMessage('AUTHENTICATION_FAILED')
            ->setCode(401)
            ->toApiJson();
    }
}
