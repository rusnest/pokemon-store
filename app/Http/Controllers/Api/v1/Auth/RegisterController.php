<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\RegisterRequest;
use App\Models\v1\User;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $userRequest = $request->only(['display_name', 'email']);
        $userRequest['password'] = bcrypt($request->password);
        $userRequest['account_type'] = 'individual';

        $user = User::create($userRequest);

        event(new Registered($user));

        return ApiResponse::createSuccessResponse()->toApiJson();
    }
}
