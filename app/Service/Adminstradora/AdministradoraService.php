<?php

namespace App\Service\Adminstradora;

use App\Models\Administradora;

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
}
