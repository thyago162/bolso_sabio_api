<?php

namespace App\Service\AdministradoraInvestimento;

use App\Models\AdministradoraInvestimento;

class AdministradoraInvestimentoService
{
    public function store($administradora_id, $investimento_id)
    {
        AdministradoraInvestimento::updateOrCreate([
            'administradora_id' => $administradora_id,
            'investimento_id' => $investimento_id
        ]);
    }
}
