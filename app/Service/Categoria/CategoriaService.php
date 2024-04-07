<?php

namespace App\Service\Categoria;

use App\Models\Categoria;

class CategoriaService
{
    public function store(string $nome_categoria, int $tipo_investimento_id)
    {
        return Categoria::firstOrCreate([
            'nome' => $nome_categoria,
            'tipo_investimento_id' => $tipo_investimento_id
        ]);
    }

    public function getPorNome(string $nome)
    {
        return Categoria::where('nome', $nome)
            ->firstOrFail();
    }

    public function getByTipoInvestimentoId($tipo_investimento_id)
    {
        return Categoria::where('tipo_investimento_id', $tipo_investimento_id)
            ->firstOrFail();
    }
}
