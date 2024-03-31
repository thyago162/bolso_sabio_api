<?php

namespace App\Http\Controllers\Api\Administradora;

use App\Http\Controllers\Controller;
use App\Service\Adminstradora\AdministradoraService;
use App\Service\Erro\ErroService;
use Illuminate\Support\Facades\Log;

class AdministradoraController extends Controller
{
    private AdministradoraService $administradora_service;

    public function __construct()
    {
        $this->administradora_service = new AdministradoraService();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return response()->json(
                $this->administradora_service->show($id)
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }
}
