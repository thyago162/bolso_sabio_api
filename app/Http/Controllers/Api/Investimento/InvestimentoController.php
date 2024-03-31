<?php

namespace App\Http\Controllers\Api\Investimento;

use App\Http\Controllers\Controller;
use App\Service\Erro\ErroService;
use App\Service\Investimento\InvestimentoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InvestimentoController extends Controller
{
    private InvestimentoService $investimento_service;

    public function __construct()
    {
        $this->investimento_service = new InvestimentoService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(
                $this->investimento_service->index()
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
                $this->investimento_service->store($request), 201
            );
        } catch (\Exception $exception) {
                Log::error($exception);

                return ErroService::report($exception);
        }
    }
}
