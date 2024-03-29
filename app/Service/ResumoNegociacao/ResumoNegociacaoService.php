<?php

namespace App\Service\ResumoNegociacao;

use App\Models\Investimento;
use App\Models\ResumoNegociacao;
use App\Service\Csv\CsvService;
use App\Service\Investimento\InvestimentoService;
use Carbon\Carbon;

class ResumoNegociacaoService
{
    private CsvService $csv_service;
    private InvestimentoService $investimento_service;

    public function __construct()
    {
        $this->csv_service = new CsvService();
        $this->investimento_service = new InvestimentoService();
    }

    public function index()
    {
        $resumo_negociacoes = ResumoNegociacao::with('investimento.administradoraInvestimento.administradora')
            ->where('user_id', 1)
            ->get()->unique('investimento_id');

       foreach ($resumo_negociacoes as $resumo_negociacao) {
           $resumo = collect(ResumoNegociacao::where('user_id', 1)
               ->where('investimento_id', $resumo_negociacao->investimento_id)
               ->get());

           $resumo_negociacao->total_compras = number_format( $resumo->sum('total_compras'), 2, ',', '.');
           $resumo_negociacao->total_vendas = number_format($resumo->sum('total_vendas'), 2, ',', '.');
           $resumo_negociacao->qnt_compras = $resumo->sum('qnt_compras');
           $resumo_negociacao->qnt_vendas = $resumo->sum('qnt_vendas');
           $resumo_negociacao->preco_medio = $resumo->avg('valor_ativo');
       }

       return $resumo_negociacoes;
    }

    public function store($request)
    {
        $resumos_negociacao = $this->csv_service->montarArray($this->csv_service->csvToArray($request->file('resumo_negociacao')));
        foreach ($resumos_negociacao as $resumo_negociacao) {
            $investimento = $this->investimento_service->getPorDescricao($resumo_negociacao['ativo']);
            if ($investimento) {
                ResumoNegociacao::create([
                    'investimento_id' => $investimento->id,
                    'total_compras' => str_replace(',', '.', $resumo_negociacao['financeiro_compra']),
                    'total_vendas' => str_replace(',', '.', $resumo_negociacao['financeiro_venda']),
                    'qnt_compras' => $resumo_negociacao['quantidade_compra'],
                    'qnt_vendas' => $resumo_negociacao['quantidade_venda'],
                    'valor_ativo' => str_replace(',', '.', $resumo_negociacao['preco']),
                    'data_negociacao' => $this->formatarData($resumo_negociacao['dt._negociacao']),
                    'user_id' => 1
                ]);
            }
        }

        return ResumoNegociacao::where('user_id', 1)->get();
    }

    private function formatarData($data)
    {
        if ($data) {
            $arr_data = explode('/', $data);
            $data_invertida = array_reverse($arr_data);

            return implode('-', $data_invertida);
        }

        return null;
    }
}
