<?php

namespace App\Service\TipoInvestimento;

use App\Models\TipoInvestimento;

class TipoInvestimentoService
{
    public function getPorAlias(string $alias_tipo_investimento)
    {
        return TipoInvestimento::where('alias', $alias_tipo_investimento)
            ->firstOrFail();
    }

    public function getPorNome(string $nome)
    {
        return TipoInvestimento::query()->whereRaw("UPPER(nome) like ?", [
            '%' . $nome . '%'
        ])->firstOrFail();
    }
}
