<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RefreshTokenController extends Controller
{
    public function refreshToken()
    {
        return ApiResponse::createSuccessResponse()
            ->setData(
                [
                    'access_token' => Auth::refresh(),
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60
                ]
            )->toApiJson();
    }
}
