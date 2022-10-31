<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\v1\User;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function verify($user_id, Request $request)
    {

        if (!$request->hasValidSignature()) {
            return ApiResponse::createSuccessResponse()
                ->setData(
                    [
                        'redirect_url' => 'fail'
                    ]
                )
                ->toApiJson();
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return ApiResponse::createSuccessResponse()
            ->setData(['redirect_url' => 'success'])
            ->toApiJson();
    }
}
