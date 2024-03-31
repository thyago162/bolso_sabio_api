<?php

namespace App\Service\Adminstradora;

use App\Models\Administradora;
use App\Models\AdministradoraInvestimento;

class AdministradoraService
{
    public function store($data)
    {
        return Administradora::updateOrCreate(
            ['cnpj' => $data['document']],
            [
                'nome' => $data['company_name'],
                'descricao' => $data['description'],
                'site' => $data['website'] ?? null,
                'logo' => isset($data['logo']) ? $data['logo']['small'] : null
            ]
        );
    }

    public function show($id)
    {
        return AdministradoraInvestimento::with('administradora')
            ->where('investimento_id', $id)
            ->firstOrFail();
    }
}
