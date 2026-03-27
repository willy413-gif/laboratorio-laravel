<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponseHelper
{
    public static function format(
        bool $success,
        int $code,
        mixed $data = null,
    ) {

        $response = [
            'success'  => $success,
            'code'     => $code,
            'location' => request()->url(),
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
}
