<?php

namespace App\DTO;

use App\Http\Requests\Investimento\InvestimentoRequest;
use Carbon\Carbon;

readonly class CadastrarInvestimentoDto
{
    public function __construct(
        public string $descricao,
        public int $categoria_id,
        public int $user_id,
        public int $tipo_investimento_id,
        public int $quantidade,
        public float $valor_unitario,
        public float $valor_aplicado,
        public float $valor_bruto,
        public float $valor_liquido,
        public float $taxa_negociada,
        public string $vencimento,
    ){}

    public static function fromRequest(InvestimentoRequest $request): self
    {
        $data = $request->validated();

        return new self(
            descricao: $data['descricao'],
            categoria_id: $data['categoria_id'],
            user_id: auth()->id(),
            tipo_investimento_id: $data['tipo_investimento_id'],
            quantidade: $data['quantidade'],
            valor_unitario: isset($data['valor_unitario']) ? floatval($data['valor_unitario']) : 0,
            valor_aplicado: floatval($data['valor_investido']),
            valor_bruto: floatval($data['valor_bruto']),
            valor_liquido: floatval($data['valor_liquido']),
            taxa_negociada: floatval($data['taxa_negociada']),
            vencimento: Carbon::parse($data['vencimento'])->format('Y-m-d'),
        );
    }
}
