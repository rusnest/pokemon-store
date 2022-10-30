<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout()
    {
        Auth::logout();
        return ApiResponse::createSuccessResponse()->toApiJson();
    }
}
