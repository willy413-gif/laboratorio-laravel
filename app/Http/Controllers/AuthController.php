<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserResquest;
use App\Services\UserServicio;

class AuthController extends Controller
{

    public function login(AuthRequest $request, UserServicio $userServicio)
    {
        return $userServicio->login($request->validated());
    }

    public function registrar(UserResquest $request, UserServicio $userServicio)
    {
        return $userServicio->registrar($request->validated());
    }

}
