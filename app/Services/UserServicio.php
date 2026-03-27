<?php

namespace App\Services;

use App\Helpers\ApiErrorHelper;
use App\Helpers\ApiResponseHelper;
use App\Http\Requests\UserResquest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserServicio
{
    public function login(array $data)
    {

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return ApiErrorHelper::format(false,401,'Credenciales inválidas');
        }

        $token = $user->createToken('access_token')->plainTextToken;

        return ApiResponseHelper::format(true, 200, [
            'access_token' => $token,
            'user' => $user
        ]);
    }

    public function registrar(array $data)
    {
        $user = User::create($data);
        return ApiResponseHelper::format(true,201,"usuario {$user->name} registrado correctamente");
    }
}
