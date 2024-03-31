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
        $anos = [request('ano') - 1, request('ano')];
        $saldo_compras = 0;
        $saldo_vendas = 0;
        $saldo_compra_cotas = 0;
        $saldo_venda_cotas = 0;
        $preco_medio_final = 0;
        $divisor = 0;
        $data = [];

        $resumo_negociacoes = ResumoNegociacao::with('investimento.administradoraInvestimento.administradora')
            ->where('user_id', 1)
            ->where('ano', request('ano'))
            ->orWhere('ano', request('ano') - 1)
            ->get()->unique('investimento_id');

        foreach ($resumo_negociacoes as $resumo_negociacao) {
            foreach ($anos as $ano) {
                $data[$resumo_negociacao->investimento_id]['investimento_id'] = $resumo_negociacao->investimento_id;
                $data[$resumo_negociacao->investimento_id]['descricao'] = $resumo_negociacao->investimento->descricao;
                $data[$resumo_negociacao->investimento_id]['ano'] = $resumo_negociacao->ano;
                $resumo = collect(ResumoNegociacao::where('investimento_id', $resumo_negociacao->investimento_id)
                    ->where('ano', $ano)
                    ->get());

                $data[$resumo_negociacao->investimento_id]['anos'][$ano]['total_comprado'] = round($resumo->sum('total_comprado'), 2);
                $data[$resumo_negociacao->investimento_id]['anos'][$ano]['total_vendido'] = round($resumo->sum('total_vendido'));
                $data[$resumo_negociacao->investimento_id]['anos'][$ano]['qnt_cotas_comprada'] = $resumo->sum('qnt_cotas_comprada');
                $data[$resumo_negociacao->investimento_id]['anos'][$ano]['qnt_cotas_vendida'] = $resumo->sum('qnt_cotas_vendida');
                $data[$resumo_negociacao->investimento_id]['anos'][$ano]['preco_medio'] = round($resumo->avg('valor_ativo'));
                $data[$resumo_negociacao->investimento_id]['anos'][$ano]['ano'] = $ano;
                $saldo_compras +=  $data[$resumo_negociacao->investimento_id]['anos'][$ano]['total_comprado'];
                $saldo_vendas +=  $data[$resumo_negociacao->investimento_id]['anos'][$ano]['total_vendido'];
                $saldo_compra_cotas += $data[$resumo_negociacao->investimento_id]['anos'][$ano]['qnt_cotas_comprada'];
                $saldo_venda_cotas += $data[$resumo_negociacao->investimento_id]['anos'][$ano]['qnt_cotas_vendida'];
                if ($data[$resumo_negociacao->investimento_id]['anos'][$ano]['preco_medio'] > 0) {
                    $preco_medio_final += $data[$resumo_negociacao->investimento_id]['anos'][$ano]['preco_medio'];
                    $divisor++;
                }
            }
            $data[$resumo_negociacao->investimento_id]['saldo_compras'] = number_format($saldo_compras, 2, ',', '.');
            $data[$resumo_negociacao->investimento_id]['saldo_vendas'] = number_format($saldo_vendas, 2, ',', '.');
            $data[$resumo_negociacao->investimento_id]['saldo_compra_cotas'] = $saldo_compra_cotas;
            $data[$resumo_negociacao->investimento_id]['saldo_venda_cotas'] = $saldo_venda_cotas;
            $data[$resumo_negociacao->investimento_id]['preco_medio'] = number_format($preco_medio_final / $divisor, 2, ',', '.');
            $data[$resumo_negociacao->investimento_id]['saldo'] = number_format($saldo_compras - $saldo_vendas, '2', ',', '.');

            $saldo_compras = 0;
            $saldo_vendas = 0;
            $saldo_venda_cotas = 0;
            $saldo_compra_cotas = 0;
            $preco_medio_final = 0;
            $divisor = 0;
        }

        return $data;


        return $resumo_negociacoes;
    }

    public function store($request)
    {
        $resumos_negociacao = $this->csv_service->montarArray($this->csv_service->csvToArray($request->file('resumo_negociacao')));
        foreach ($resumos_negociacao as $resumo_negociacao) {
            $nome_ativo = $this->nomeAtivo($resumo_negociacao['ativo']);
            $investimento = $this->investimento_service->getPorDescricao($nome_ativo);
            if (!$investimento) {
                $investimento = $this->investimento_service->cadastrarAtivoVendido($nome_ativo);
            }

            ResumoNegociacao::create([
                'investimento_id' => $investimento->id,
                'total_comprado' => str_replace(',', '.', $resumo_negociacao['financeiro_compra']),
                'total_vendido' => str_replace(',', '.', $resumo_negociacao['financeiro_venda']),
                'qnt_cotas_comprada' => $resumo_negociacao['quantidade_compra'],
                'qnt_cotas_vendida' => $resumo_negociacao['quantidade_venda'],
                'valor_ativo' => str_replace(',', '.', $resumo_negociacao['preco']),
                'data_negociacao' => $this->formatarData($resumo_negociacao['dt._negociacao']),
                'user_id' => 1,
                'mes' => $this->getMesOuAno($resumo_negociacao['dt._negociacao'], 'mes'),
                'ano' => $this->getMesOuAno($resumo_negociacao['dt._negociacao'], 'ano')
            ]);
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

    private function getMesOuAno($data, $flag)
    {
        $array_dt = explode('/', $data);

        return $flag == 'mes' ?
            $array_dt[1] :
            $array_dt[2];
    }


    public function buscarAnos()
    {
        $array_anos = [];
        $anos = ResumoNegociacao::where('user_id', 1)
            ->select('ano')
            ->orderBy('ano')
            ->get()
            ->unique('ano');

        foreach ($anos as $ano) {
            $array_anos[] = $ano->ano;
        }

        return $array_anos;
    }

    private function nomeAtivo($ativo)
    {
        $nome_ativo = $ativo;
        $ultima_letra = substr($nome_ativo, -1);

        return $ultima_letra === 'F' ? (substr($nome_ativo, 0, -1)) : $ativo;
    }
}
