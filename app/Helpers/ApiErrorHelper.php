<?php

namespace App\Helpers;


class ApiErrorHelper
{
    public static function format(
        bool $success,
        int $code,
        mixed $errors = null,
    ) {

        $response = [
            'success'  => $success,
            'code'     => $code,
            'location' => request()->url(),
        ];


        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
