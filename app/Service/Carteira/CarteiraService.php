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
        $cores = [];
        $investimentos = collect(Investimento::with('tipoInvestimento:id,nome,cor')->where('user_id', 2)
            ->select('id', 'tipo_investimento_id', 'valor_bruto')
            ->get());

        foreach ($investimentos->unique('tipo_investimento_id') as $investimento) {
            $labels[] = $investimento->tipoInvestimento->nome;
            $cores[] = $investimento->tipoInvestimento->cor;
            $valores[] = Investimento::where('user_id', auth()->id())
                ->where('tipo_investimento_id', $investimento->tipo_investimento_id)
                ->sum('valor_bruto');
        }

        return [
            'label' => $labels,
            'valores' => $valores,
            'cores' => $cores
        ];
    }

    public function getTotalPorAno()
    {
        $cores = ['#FF8C00', '#8A2BE2', '#00FF7F', '#20B2AA', '#4682B4', '#A52A2A'];
        $labels = [];
        $data = [];
        $investimentos = collect(Investimento::has('resumoNegociacao')
            ->with('tipoInvestimento')
            ->where('user_id', auth()->id())
            ->get());
        $resumo_negociacoes = collect(ResumoNegociacao::where('user_id', auth()->id())
            ->get());

        foreach ($resumo_negociacoes->unique('ano') as $resumo_negociacao) {
            $labels[] = $resumo_negociacao->ano;
        }

        foreach ($labels as $label) {
            foreach ($investimentos->unique('tipo_investimento_id') as $key => $investimento) {
                $data['datasets'][$key]['label'] = $investimento->tipoInvestimento->nome;
                $data['datasets'][$key]['backgroundColor'] = $investimento->tipoInvestimento->cor;

                $resumo_negociacao_collection = collect(ResumoNegociacao::whereHas('investimento', function ($query) use ($investimento, $label) {
                    $query->where('tipo_investimento_id', $investimento->tipo_investimento_id);
                })->where('user_id', auth()->id())->where('ano', '<=', $label)->get());

                $total_comprado = $resumo_negociacao_collection->sum('total_comprado');
                $total_vendido = $resumo_negociacao_collection->sum('total_vendido');

                $data['datasets'][$key]['data'][] = $total_comprado - $total_vendido;
            }
        }

        $data['labels'] = $labels;

        return $data;
    }
}
