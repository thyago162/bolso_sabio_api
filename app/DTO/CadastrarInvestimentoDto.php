<?php

namespace App\DTO;

use App\Http\Requests\Investimento\InvestimentoRequest;

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
            valor_unitario: $data['valor_unitario'],
            valor_aplicado: $data['valor_aplicado'],
            valor_bruto: $data['valor_bruto'],
            valor_liquido: $data['valor_liquido'],
            taxa_negociada: $data['taxa_negociada'],
            vencimento: $data['vencimento'],
        );
    }
}
