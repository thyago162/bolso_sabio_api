<?php

namespace App\Service\Carteira;

use App\Models\Investimento;

class CarteiraService
{
    public function index()
    {
        return Investimento::where('user_id', auth()->id())
            ->sum('valor_bruto');
    }
}
