<?php

namespace App\Service\Carteira;

use App\Models\Investimento;

class CarteiraService
{
    public function index()
    {
        return Investimento::where('user_id', auth()->id())
            ->sum('valor_bruto');
    }

    public function getTotalPorTipoInvestimento()
    {
        $labels = [];
        $valores = [];
        $investimentos = collect(Investimento::with('tipoInvestimento:id,nome')->where('user_id', 2)
            ->select('id', 'tipo_investimento_id', 'valor_bruto')
            ->get());

        foreach ($investimentos->unique('tipo_investimento_id') as $investimento) {
            $labels[] = $investimento->tipoInvestimento->nome;
            $valores[] = Investimento::where('user_id', 2)->where('tipo_investimento_id', $investimento->tipo_investimento_id)->sum('valor_bruto');
        }

        return [
            'label' => $labels,
            'valores' => $valores
        ];
    }
}
