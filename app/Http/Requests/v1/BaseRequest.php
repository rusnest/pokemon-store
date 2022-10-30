<?php

namespace App\Http\Requests\v1;

use App\Enums\StatusCodeEnum;
use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $listErrors = [];
        foreach ($validator->errors()->all() as $error) {
            $errorMessage = StatusCodeEnum::from($error)->name;
            array_push(
                $listErrors, [
                'message' => $errorMessage,
                'code' => $error
                ]
            );
        }

        $response = ApiResponse::createFailedResponse()
            ->setError($listErrors)
            ->setMessage('VALIDATION_FAILED')
            ->setCode(422)
            ->toApiJson();

        throw new ValidationException($validator, $response);
    }
}
