<?php

namespace App\Http\Requests\v1;

use App\Enums\StatusCodeEnum;
use App\Models\v1\User;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => ['required','exists:users,email'],
            'password' => [
                'required','min:8',
                function ($attribute, $value, $fail) {
                    $user = User::where('email', $this->email)->first();

                    if (isset($user) && !Hash::check($value, $user->password, [])) {
                        return $fail(StatusCodeEnum::LOGIN_PASSWORD_INCORRECT->value);
                    }
                }
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => StatusCodeEnum::LOGIN_EMAIL_REQUIRED->value,
            'email.exists' => StatusCodeEnum::LOGIN_EMAIL_DOES_NOT_EXIST->value,
            'password.required' => StatusCodeEnum::LOGIN_PASSWORD_REQUIRED->value,
            'password.min' => StatusCodeEnum::LOGIN_PASSWORD_LEAST->value
        ];
    }
}
