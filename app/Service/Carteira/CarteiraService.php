<?php

namespace App\Service\Carteira;

use App\Models\Investimento;
use App\Models\ResumoNegociacao;

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

    public function getTotalPorAno()
    {
        $cores = ['#FF8C00', '#8A2BE2', '#00FF7F', '#20B2AA', '#4682B4', '#A52A2A'];
        $labels = [];
        $data = [];
        $valores = [];
        $investimentos = collect(Investimento::has('resumoNegociacao')->with('tipoInvestimento')->where('user_id', 2)->get());
        $resumo_negociacoes = collect(ResumoNegociacao::where('user_id', 2)->get());

        foreach ($resumo_negociacoes->unique('ano') as $resumo_negociacao) {
            $labels[] = $resumo_negociacao->ano;
        }

        foreach ($labels as $label) {
            foreach ($investimentos->unique('tipo_investimento_id') as $key => $investimento) {
                $data['datasets'][$key]['label'] = $investimento->tipoInvestimento->nome;
                $data['datasets'][$key]['backgroundColor'] = $cores[rand(0, count($cores) - 1)];

                $resumo_negociacao_collection = collect(ResumoNegociacao::whereHas('investimento', function ($query) use ($investimento, $label) {
                    $query->where('tipo_investimento_id', $investimento->tipo_investimento_id);
                })->where('user_id', 2)->where('ano', '<=',$label)->get());

                $total_comprado = $resumo_negociacao_collection->sum('total_comprado');
                $total_vendido = $resumo_negociacao_collection->sum('total_vendido');

                $data['datasets'][$key]['data'][] = $total_comprado - $total_vendido;
            }
        }

        $data['labels'] = $labels;

        return $data;
    }
}
