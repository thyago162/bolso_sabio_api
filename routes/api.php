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
Route::middleware(['auth:api'])->group(function () {
    ###################################################################################################################
    # ROTAS AUTH

    Route::get('usuario-autenticado', [\App\Http\Controllers\Api\Auth\AuthController::class, 'usuarioAutenticado']);

    ###################################################################################################################
    # ROTAS INVESTIMENTO
    Route::get('investimentos/buscar-ativo', [
            \App\Http\Controllers\Api\Investimento\InvestimentoController::class,
            'buscarAtivo']
    );

    Route::post('investimentos/importar', [\App\Http\Controllers\Api\Investimento\InvestimentoController::class, 'importar']);
    Route::apiResource('investimentos', \App\Http\Controllers\Api\Investimento\InvestimentoController::class);

    ####################################################################################################################
    # RESUMO NEGOCIAÇÃO
    Route::get('resumo-negociacao/buscar-resumo-negociacao', [\App\Http\Controllers\Api\ResumoNegociacao\ResumoNegociacaoController::class, 'resumoNegociacao']);
    Route::post('resumo-negociacao/importar', [\App\Http\Controllers\Api\ResumoNegociacao\ResumoNegociacaoController::class, 'importar']);
    Route::get('resumo-negociacao/anos', [\App\Http\Controllers\Api\ResumoNegociacao\ResumoNegociacaoController::class, 'buscarAnos']);
    Route::apiResource('resumo-negociacao', \App\Http\Controllers\Api\ResumoNegociacao\ResumoNegociacaoController::class);

    ###################################################################################################################
    # ADMINISTRADORA
    Route::apiResource('administradora', \App\Http\Controllers\Api\Administradora\AdministradoraController::class);

    ###################################################################################################################
    # CARTEIRA

    Route::apiResource('carteira', \App\Http\Controllers\Api\Carteira\CarteiraController::class);

    #####################################################################################################################
    # TIPO INVESTIMENTO
    Route::apiResource('tipo-investimento', \App\Http\Controllers\Api\TipoInvestimento\TipoInvestimentoControlle::class)->only('index');

    #################################################################################################################
    # CATEGORIA
    Route::get('categoria/', [\App\Http\Controllers\Api\Categoria\CategoriaController::class, 'getCategoria']);
    Route::get('carteira/total-por-ano', [\App\Http\Controllers\Api\Carteira\CarteiraController::class, 'totalPorAno']);
    Route::get('carteira/total-por-tipo-investimento', [\App\Http\Controllers\Api\Carteira\CarteiraController::class, 'totalPorTipoInvestimento']);
});
