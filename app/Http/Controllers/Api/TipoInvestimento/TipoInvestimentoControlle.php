<?php

namespace App\Http\Controllers\Api\TipoInvestimento;

use App\Http\Controllers\Controller;
use App\Service\Erro\ErroService;
use App\Service\TipoInvestimento\TipoInvestimentoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TipoInvestimentoControlle extends Controller
{
    private TipoInvestimentoService $tipo_investimento_service;

    public function __construct()
    {
        $this->tipo_investimento_service = new TipoInvestimentoService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(
                $this->tipo_investimento_service->index()
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }
}
