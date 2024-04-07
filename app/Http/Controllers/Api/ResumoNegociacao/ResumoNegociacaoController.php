<?php

namespace App\Http\Controllers\Api\ResumoNegociacao;

use App\Http\Controllers\Controller;
use App\Service\Erro\ErroService;
use App\Service\ResumoNegociacao\ResumoNegociacaoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ResumoNegociacaoController extends Controller
{
    private ResumoNegociacaoService $resumo_negociacao_service;

    public function __construct()
    {
        $this->resumo_negociacao_service = new ResumoNegociacaoService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(
                $this->resumo_negociacao_service->index()
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            return response()->json(
                $this->resumo_negociacao_service->store($request), 201
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }

    public function importar(Request $request)
    {
        try {
            return response()->json(
                $this->resumo_negociacao_service->importar($request), 201
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }

    public function buscarAnos()
    {
        try {
            return response()->json(
                $this->resumo_negociacao_service->buscarAnos(), 201
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }
}
