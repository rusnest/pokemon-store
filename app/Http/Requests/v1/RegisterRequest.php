<?php

namespace App\Http\Requests\v1;

use App\Enums\StatusCodeEnum;

class RegisterRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'display_name' => ['required'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8']
        ];
    }

    public function messages()
    {
        return [
            'display_name.required' => StatusCodeEnum::REGISTER_DISPLAY_NAME_REQUIRED->value,
            'email.required' => StatusCodeEnum::REGISTER_EMAIL_REQUIRED->value,
            'email.unique' => StatusCodeEnum::REGISTER_EMAIL_EXISTED->value,
            'password.required' => StatusCodeEnum::REGISTER_PASSWORD_REQUIRED->value,
            'password.confirmed' => StatusCodeEnum::REGISTER_PASSWORD_NOT_CONFIRMED->value,
            'password.min' => StatusCodeEnum::REGISTER_PASSWORD_LEAST->value
        ];
    }
}
