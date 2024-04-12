<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Service\Erro\ErroService;
use App\Service\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private UserService $user_service;

    public function __construct()
    {
        $this->user_service = new UserService();
    }

    /**
     * Display the specified resource.
     */
    public function dadosUsuario()
    {
        try {
            return response()->json(
                $this->user_service->show()
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            return response()->json(
                $this->user_service->update($request->all(), $id)
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }
}
