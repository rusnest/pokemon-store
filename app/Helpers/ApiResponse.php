<?php

namespace App\Helpers;

use App\Enums\StatusCodeEnum;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse
{
    private $status;
    private $message;
    private $error;
    private $data;
    private $code;

    public static function createSuccessResponse()
    {
        $new = new self;

        $new->status = "success";
        $new->message = "SUCCESS";
        $new->code = 200;
        $new->data = null;
        $new->error = null;

        return $new;
    }

    public static function createFailedResponse()
    {
        $new = new self;
        $new->status = "fail";
        return $new;
    }

    public static function createServerErrorResponse()
    {
        $new = new self;
        $new->status = "error";
        $new->code = 500;
        $new->error = [[
            'message' => StatusCodeEnum::INTERNAL_SERVER_ERROR->name,
            'code' => StatusCodeEnum::INTERNAL_SERVER_ERROR->value,
        ]];
        $new->message = 'INTERNAL_SERVER_ERROR';
        return $new;
    }

    public static function createValidationFailedResponse()
    {
        $new = new self;
        $new->status = "fail";
        $new->error = [[
            'code' => StatusCodeEnum::API_ENDPOINT_NOT_FOUND->value,
            'message' => StatusCodeEnum::API_ENDPOINT_NOT_FOUND->name
        ]];
        $new->message = 'API_ENDPOINT_NOT_FOUND';
        return $new;
    }

    public function setMessage($message = null)
    {
        $this->message = $message;
        return $this;
    }

    public function setError($error = null)
    {
        $this->error = $error;
        return $this;
    }

    public function setData($data = null)
    {
        $this->data = $data;
        return $this;
    }
    public function setCode($code = null)
    {
        $this->code = $code;
        return $this;
    }

    public function toApiJson()
    {
        return new JsonResponse(
            [
            'status' => $this->status,
            'message' =>  $this->message,
            'error' =>  $this->error,
            'data' =>  $this->data
            ], $this->code
        );
    }
}
