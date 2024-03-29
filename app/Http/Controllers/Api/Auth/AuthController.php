<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cadastro\CadastroRequest;
use App\Http\Resources\User\UserResource;
use App\Service\Auth\AuthService;
use App\Service\Erro\ErroService;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private AuthService $auth_service;

    public function __construct()
    {
        $this->auth_service = new AuthService();
    }
    public function registrar(CadastroRequest $request)
    {
        try {
            return UserResource::make(
                $this->auth_service->registrarUsuario($request->validated())
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }

    public function usuarioAutenticado()
    {
        try {
            return response()->json(auth()->user());
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }
}
