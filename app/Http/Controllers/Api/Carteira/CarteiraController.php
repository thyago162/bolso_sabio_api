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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
