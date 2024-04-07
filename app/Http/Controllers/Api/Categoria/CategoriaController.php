<?php

namespace App\Http\Controllers\Api\Categoria;

use App\Http\Controllers\Controller;
use App\Service\Carteira\CarteiraService;
use App\Service\Categoria\CategoriaService;
use App\Service\Erro\ErroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{
    private CategoriaService $categoria_service;

    public function __construct()
    {
        $this->categoria_service = new CategoriaService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function getCategoria()
    {
        try {
            return response()->json(
                $this->categoria_service->getByTipoInvestimentoId(request('tipo_investimento_id'))
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }
}
