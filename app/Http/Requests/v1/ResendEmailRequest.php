<?php

namespace App\Http\Requests\v1;

use App\Enums\StatusCodeEnum;
use App\Models\v1\User;

class ResendEmailRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => [
                'required', 'exists:users,email',
                function ($attribute, $value, $fail) {
                    $user = User::where('email', $value)->first();
                    if (isset($user->email_verified_at)) {
                        return $fail(StatusCodeEnum::RESEND_VERIFY_EMAIL_VERIFIED->value);
                    }
                }
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => StatusCodeEnum::RESEND_VERIFY_EMAIL_REQUIRED->value,
            'email.exists' => StatusCodeEnum::RESEND_VERIFY_EMAIL_DOES_NOT_EXIST->value
        ];
    }
}
