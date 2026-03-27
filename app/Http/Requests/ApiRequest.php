<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponseHelper;

class ApiRequest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
    throw new HttpResponseException(
        ApiResponseHelper::format(
            false,
            422,
            null,
            $validator->errors()
        )
    );
    }

}
