<?php

namespace App\Http\Controllers\Api\Investimento;

use App\Http\Controllers\Controller;
use App\Http\Requests\Investimento\InvestimentoRequest;
use App\Service\Erro\ErroService;
use App\Service\Investimento\InvestimentoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\DTO\CadastrarInvestimentoDto;

class InvestimentoController extends Controller
{


    public function __construct(private readonly InvestimentoService $investimento_service)
    {
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
    public function store(InvestimentoRequest $request)
    {
        try {
            $dto = CadastrarInvestimentoDto::fromRequest($request);

            return response()->json($this->investimento_service->salvar($dto), 201);
        } catch (\Exception $exception) {
                Log::error($exception);

                return ErroService::report($exception);
        }
    }

    public function importar(Request $request)
    {
        try {
            return response()->json(
                $this->investimento_service->importar($request), 201
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }

    public function buscarAtivo(Request $request)
    {
        try {
            return response()->json(
                $this->investimento_service->buscarAtivoPorNome(strtoupper($request->descricao))
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }

    public function show($id)
    {
        try {
            return response()->json(
                $this->investimento_service->show($id)
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }
}
