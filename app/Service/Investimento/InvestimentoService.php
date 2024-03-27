<?php

namespace App\Service\Investimento;

use App\Enum\MensagemRetornoEnum;
use App\Exceptions\PersonalException;
use App\Models\Investimento;
use App\Service\AdministradoraInvestimento\AdministradoraInvestimentoService;
use App\Service\Adminstradora\AdministradoraService;
use App\Service\Api\ApiService;
use App\Service\Categoria\CategoriaService;
use App\Service\TipoInvestimento\TipoInvestimentoService;
use Carbon\Carbon;
use Normalizer;

class InvestimentoService
{
    private CategoriaService $categoria_service;
    private TipoInvestimentoService $tipo_investimento_service;
    private ApiService $api_service;
    private AdministradoraService $administradora_service;
    private AdministradoraInvestimentoService $administradora_investimento_service;

    public function __construct()
    {
        $this->categoria_service = new CategoriaService();
        $this->tipo_investimento_service = new TipoInvestimentoService();
        $this->administradora_service = new AdministradoraService();
        $this->administradora_investimento_service = new AdministradoraInvestimentoService();
        $this->api_service = new ApiService();
    }

    public function buscarAtivoPorNome(string $nome_ativo): array
    {
        $response = $this->api_service->getAtivos([$nome_ativo]);
        if ($response->status() >= 400) {
            throw new PersonalException('Ativo não encontrado, verifique o nome e tente novamente', 404);
        }

        $payload = $response->json();
        $tipo_investimento = $this->tipo_investimento_service->getPorAlias($payload['results'][strtoupper($nome_ativo)]['kind']);
        $categoria = $this->categoria_service->store($payload['results'][strtoupper($nome_ativo)]['sector'], $tipo_investimento->id);

        return [
            'tipo_investimento_id' => $tipo_investimento->id,
            'categoria_id' => $categoria->id,
            'ativo' => $payload['results'][strtoupper($nome_ativo)]
        ];
    }

    public function index()
    {
        return Investimento::with(['categoria', 'tipoInvestimento'])
            ->where('user_id', auth()->id())
            ->paginate(10);

    }

    public function store($request)
    {
        $investimentos = $this->montarArray($this->csvToArray($request->file('file')));
        foreach ($investimentos as $investimento) {
            $tipo_investimento = $this->tipo_investimento_service->getPorNome($investimento['TIPO_DE_INVESTIMENTO']);
            if ($tipo_investimento->tipo_renda != 'Fixa') {
                $data = $this->buscarAtivoPorNome(strtolower($investimento['DESCRICAO']));
                $investimento = $this->save($investimento, $data);
                if (!$investimento) {
                    throw new PersonalException(MensagemRetornoEnum::ERROR->value, 400);
                }

                $administradora = $this->administradora_service->store($data['ativo']);
                $this->administradora_investimento_service->store($administradora->id, $investimento->id);
            } else {
               $categoria = $this->categoria_service->store('Papel', $tipo_investimento->id);
                $this->save(
                    $investimento,
                    ['tipo_investimento_id' => $tipo_investimento->id, 'categoria_id' => $categoria->id, 'ativo' => []]
                );

            }
        }

        return [];
    }

    private function csvToArray($arquivo)
    {
        if (($handle = fopen($arquivo, 'r')) !== FALSE) {
            $i = 0;
            while (($lineArray = fgetcsv($handle, 4000, ';', '"')) !== FALSE) {
                for ($j = 0; $j < count($lineArray); $j++) {
                    $arr[$i][$j] = $lineArray[$j];
                }
                $i++;
            }
            fclose($handle);
        }

        return $arr;
    }

    private function montarArray($data)
    {
        array_shift($data);
        $count = count($data) - 1;
        $labels = array_shift($data);

        foreach ($labels as $label) {
            $normalized = Normalizer::normalize($label, Normalizer::NFD);
            $texto = preg_replace('/[\x{0300}-\x{036F}]/u', '', $normalized);
            $keys[] = str_replace(' ', '_', $texto);
        }

        for ($j = 0; $j < $count; $j++) {
            $d = array_combine($keys, $data[$j]);
            $newArray[$j] = $d;
        }

        return $newArray;
    }

    private function save($investimento, $data)
    {
        return Investimento::updateOrCreate(['descricao' => $investimento['DESCRICAO']],[
            'descricao' => $investimento['DESCRICAO'],
            'categoria_id' => $data['categoria_id'],
            'user_id' => 1,
            'tipo_investimento_id' => $data['tipo_investimento_id'],
            'quantidade' => $investimento['QUANTIDADE'] ? $this->formatarValor($investimento['QUANTIDADE']) : 0,
            'valor_unitario' => isset($data['price']) ? $this->formatarValor($data['price']) : 0,
            'valor_aplicado' => $investimento['VALOR_APLICADO'] ? $this->formatarValor($investimento['VALOR_APLICADO']) : 0,
            'valor_bruto' => $investimento['VALOR_BRUTO'] ? $this->formatarValor($investimento['VALOR_BRUTO']) : 0,
            'valor_liquido' => $investimento['VALOR_LIQUIDO'] ? $this->formatarValor($investimento['VALOR_LIQUIDO']) : 0,
            'taxa_negociada' => $investimento['TAXA_NEGOCIADA'],
            'vencimento' => '2024-10-10'
        ]);
    }

    private function formatarValor($valor)
    {
        $valor_formatado = str_replace('.', '', $valor);
        $valor_formatado = str_replace('R$', '', $valor_formatado);

        return str_replace(',', '.', $valor_formatado);
    }
}
