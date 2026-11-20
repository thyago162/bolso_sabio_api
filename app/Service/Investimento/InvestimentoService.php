<?php

namespace App\Service\Investimento;

use App\DTO\CadastrarInvestimentoDto;
use App\Enum\MensagemRetornoEnum;
use App\Enum\TipoCategoriaEnum;
use App\Enum\TipoInvestimentoEnum;
use App\Exceptions\PersonalException;
use App\Models\Investimento;
use App\Service\AdministradoraInvestimento\AdministradoraInvestimentoService;
use App\Service\Adminstradora\AdministradoraService;
use App\Service\Api\ApiService;
use App\Service\Categoria\CategoriaService;
use App\Service\Csv\CsvService;
use App\Service\TipoInvestimento\TipoInvestimentoService;


readonly class InvestimentoService
{
    public function __construct(
        private CategoriaService                  $categoria_service,
        private TipoInvestimentoService           $tipo_investimento_service,
        private ApiService                        $api_service,
        private AdministradoraService             $administradora_service,
        private AdministradoraInvestimentoService $administradora_investimento_service,
        private CsvService                        $csv_service
    )
    {
    }

    /**
     * @param string $nome_ativo
     * @param int|null $tipo_investimento_id
     *
     * @return array
     * @throws PersonalException
     */
    public function buscarAtivoPorNome(string $nome_ativo, int $tipo_investimento_id = null): array
    {
        $response = $this->api_service->getAtivos([$nome_ativo]);
        if ($response->status() >= 400) {
            throw new PersonalException(MensagemRetornoEnum::ATIVO_NAO_ENCONTRADO->value, 404);
        }

        $payload = $response->json();
        if (isset($payload['results'][strtoupper($nome_ativo)]['error'])) {
            return [
                'categoria_id' => null,
                'tipo_investimento_id' => $tipo_investimento_id,
                'ativo' => []
            ];
        }

        if (!$tipo_investimento_id) {
            $tipo_investimento = $this->tipo_investimento_service->getPorAlias($payload['results'][strtoupper($nome_ativo)]['kind']);
            $tipo_investimento_id = $tipo_investimento->id;
        }

        $categoria = isset($payload['results'][strtoupper($nome_ativo)]['error']) ?
            $this->categoria_service->getPorNome('Título') :
            $this->categoria_service->store($payload['results'][strtoupper($nome_ativo)]['sector'], $tipo_investimento_id);

        return [
            'tipo_investimento_id' => $tipo_investimento_id,
            'categoria_id' => $categoria->id,
            'ativo' => $payload['results'][strtoupper($nome_ativo)]
        ];
    }

    public function index($tipo_investimento_id = null)
    {
        $investimento = Investimento::query()
            ->with(['categoria', 'tipoInvestimento'])
            ->tipoInvestimento($tipo_investimento_id)
            ->where('user_id', auth()->id());

        if (request('tipo_exibicao') == 'card') {
            return $investimento->get();
        }

        return $investimento->orderBy('tipo_investimento_id')->paginate(request('per_page'));
    }

    /**
     * @param CadastrarInvestimentoDto $dto
     * @return Investimento
     */
    public function salvar(CadastrarInvestimentoDto $dto): Investimento
    {
        return Investimento::updateOrCreate([
            'user_id' => auth()->id(),
            'descricao' => $dto->descricao,
            'tipo_investimento_id' => $dto->tipo_investimento_id,
            'categoria_id' => $dto->categoria_id,
        ], [
            'valor_liquido' => $dto->valor_liquido,
            'valor_bruto' => $dto->valor_bruto,
            'valor_aplicado' => $dto->valor_aplicado,
            'taxa_negociada' => $dto->taxa_negociada,
            'vencimento' => $dto->vencimento,
            'valor_unitario' => $dto->valor_unitario,
        ]);
    }

    public function importar($request)
    {
        $investimentos = $this->csv_service->montarArray($this->csv_service->csvToArray($request->file('investimentos')));
        foreach ($investimentos as $investimento) {
            \DB::transaction(function () use ($investimento) {
                $tipo_investimento = $this->tipo_investimento_service->getPorNome($investimento['tipo_de_investimento']);
                if ($tipo_investimento->tipo_renda == 'Fixa') {
                    $categoria = $this->categoria_service->store('Título', $tipo_investimento->id);
                    if (!$categoria) {
                        throw new PersonalException(MensagemRetornoEnum::SAVE_CATEGORIA_FAIL->value, 404);
                    }

                    $data = ['tipo_investimento_id' => $tipo_investimento->id, 'categoria_id' => $categoria->id, 'ativo' => []];
                } else {
                    $data = $this->buscarAtivoPorNome(strtolower($investimento['descricao']), $tipo_investimento->id);
                }

                $investimento = $this->save(
                    investimento: $investimento,
                    data: $data,
                    tipo_investimento_id: $tipo_investimento->id
                );

                if (!$investimento) {
                    throw new PersonalException(MensagemRetornoEnum::ERROR->value, 400);
                }

                if ($tipo_investimento->tipo_renda != 'Fixa' && isset($data['ativo']['document'])) {
                    $administradora = $this->administradora_service->store($data['ativo']);
                    $this->administradora_investimento_service->store($administradora->id, $investimento->id);
                }
            });
        }

        return Investimento::where('user_id', auth()->id())->get();
    }

    private function save($investimento, $data, $tipo_investimento_id)
    {
        return Investimento::create(
            [
                'descricao' => $investimento['descricao'],
                'categoria_id' => $data['categoria_id'],
                'user_id' => auth()->id(),
                'tipo_investimento_id' => $tipo_investimento_id,
                'quantidade' => $investimento['quantidade'] ? $this->formatarValor($investimento['quantidade']) : 0,
                'valor_unitario' => isset($data['price']) ? $this->formatarValor($data['price']) : 0,
                'valor_aplicado' => $investimento['valor_aplicado'] ? $this->formatarValor($investimento['valor_aplicado']) : 0,
                'valor_bruto' => $investimento['valor_bruto'] ? $this->formatarValor($investimento['valor_bruto']) : 0,
                'valor_liquido' => $investimento['valor_liquido'] ? $this->formatarValor($investimento['valor_liquido']) : 0,
                'taxa_negociada' => $investimento['taxa_negociada'],
                'vencimento' => $this->formatarData($investimento['vencimento'])
            ]);
    }

    private function formatarValor($valor)
    {
        $valor_formatado = str_replace('.', '', $valor);
        $valor_formatado = str_replace('R$', '', $valor_formatado);

        return str_replace(',', '.', $valor_formatado);
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

    public function getPorDescricao($descricao)
    {
        return Investimento::where('user_id', auth()->id())
            ->where('descricao', $descricao)
            ->first();
    }

    /**
     * @throws PersonalException
     */
    public function cadastrarAtivoVendido($nome_ativo)
    {
        $data = $this->buscarAtivoPorNome(strtoupper($nome_ativo));
        return Investimento::updateOrCreate([
            'descricao' => $nome_ativo,
            'user_id' => auth()->id(),
        ], [
            'descricao' => $nome_ativo,
            'categoria_id' => !empty($data['categoria_id']) ? $data['categoria_id'] : TipoCategoriaEnum::FUNDOS_INVESTIMENTO->value,
            'tipo_investimento_id' => !empty($data) ? $data['tipo_investimento_id'] : TipoInvestimentoEnum::ACOES->value,
            'quantidade' => 0,
            'valor_unitario' => isset($data['price']) ? $this->formatarValor($data['price']) : 0,
            'valor_aplicado' => 0,
            'valor_bruto' => 0,
            'valor_liquido' => 0,
            'deleted_at' => now()
        ]);
    }

    public function show($id)
    {
        return Investimento::with(['tipoInvestimento', 'categoria', 'administradoraInvestimento.administradora'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
    }
}
