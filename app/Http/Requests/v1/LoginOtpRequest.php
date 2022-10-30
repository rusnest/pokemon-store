<?php

namespace App\Http\Requests\v1;

use App\Enums\StatusCodeEnum;

class LoginOtpRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'exists:users,email']
        ];
    }

    public function messages()
    {
        return [
            'email.required' => StatusCodeEnum::LOGIN_OTP_EMAIL_REQUIRED->value,
            'email.exists' => StatusCodeEnum::LOGIN_OTP_EMAIL_DOES_NOT_EXIST->value
        ];
    }
}
