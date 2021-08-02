<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

trait ApiFailedValidationTrait
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => '',
                'data' => null,
                'errors' => $validator->getMessageBag(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
