<?php

namespace App\Http\Controllers\Api\Carteira;

use App\Http\Controllers\Controller;
use App\Service\Carteira\CarteiraService;
use App\Service\Erro\ErroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CarteiraController extends Controller
{
    private CarteiraService $carteira_service;

    public function __construct()
    {
        $this->carteira_service = new CarteiraService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(
                $this->carteira_service->index()
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }

    public function totalPorTipoInvestimento()
    {
        try {
            return response()->json(
                $this->carteira_service->getTotalPorTipoInvestimento()
            );
        } catch (\Exception $exception) {
            Log::error($exception);

            return ErroService::report($exception);
        }
    }


}
