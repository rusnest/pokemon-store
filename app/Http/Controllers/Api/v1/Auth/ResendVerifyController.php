<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ResendEmailRequest;
use App\Models\v1\User;

class ResendVerifyController extends Controller
{
    public function resendEmail(ResendEmailRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $user->sendEmailVerificationNotification();
        return ApiResponse::createSuccessResponse()->toApiJson();
    }
}
