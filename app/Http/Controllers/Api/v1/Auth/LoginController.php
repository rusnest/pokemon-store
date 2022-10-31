<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Enums\StatusCodeEnum;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\LoginOtpRequest;
use App\Http\Requests\v1\LoginRequest;
use App\Models\v1\LoginToken;
use App\Models\v1\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginWithPassword(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = Auth::attempt($credentials)) {
            return ApiResponse::createSuccessResponse()
                ->setData(
                    [
                        'token_type' => 'Bearer',
                        'access_token' => $token,
                        'expires_in' => auth('api')->factory()->getTTL() * 60,
                        'user' => Auth::user()
                    ]
                )->toApiJson();
        }
    }

    public function loginEmailOtp(LoginOtpRequest $request)
    {
        User::whereEmail($request->email)->first()->sendLoginLink();
        return ApiResponse::createSuccessResponse()->toApiJson();
    }

    public function verifyLoginOtp(Request $request, $token)
    {
        $token = LoginToken::whereToken(hash('sha256', $token))->firstOrFail();

        if (!($request->hasValidSignature() && $token->isValid())) {
            return ApiResponse::createFailedResponse()
                ->setCode(401)
                ->setError(
                    [
                        'code' => StatusCodeEnum::LOGIN_OTP_TOKEN_INVALID->value,
                        'message' => StatusCodeEnum::LOGIN_OTP_TOKEN_INVALID->name
                    ]
                )->toApiJson();
        }
        $token->consume();
        $token = Auth::login($token->user);
        return ApiResponse::createSuccessResponse()
            ->setData(
                [
                    'token_type' => 'Bearer',
                    'access_token' => $token,
                    'expires_in' => auth('api')->factory()->getTTL() * 60,
                    'user' => Auth::user()
                ]
            )->toApiJson();
    }
}
