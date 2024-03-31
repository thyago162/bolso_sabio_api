<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('cadastrar', [\App\Http\Controllers\Api\Auth\AuthController::class, 'registrar']);
Route::middleware([])->group(function () {
    ###################################################################################################################
    # ROTAS AUTH

    Route::get('usuario-autenticado', [\App\Http\Controllers\Api\Auth\AuthController::class, 'usuarioAutenticado']);

    ###################################################################################################################
    # ROTAS INVESTIMENTO

    Route::get('investimentos/buscar-info-ativo', [
            \App\Http\Controllers\Api\Investimento\InvestimentoController::class,
            'buscarInfoAtivo']
    );
    Route::apiResource('investimentos', \App\Http\Controllers\Api\Investimento\InvestimentoController::class);

    ####################################################################################################################
    # RESUMO NEGOCIAÇÃO
    Route::get('resumo-negociacao/anos', [\App\Http\Controllers\Api\ResumoNegociacao\ResumoNegociacaoController::class, 'buscarAnos']);
    Route::apiResource('resumo-negociacao', \App\Http\Controllers\Api\ResumoNegociacao\ResumoNegociacaoController::class);

    ###################################################################################################################
    # ADMINISTRADORA
    Route::apiResource('administradora', \App\Http\Controllers\Api\Administradora\AdministradoraController::class);
});
