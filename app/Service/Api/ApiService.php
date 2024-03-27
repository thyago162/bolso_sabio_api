<?php

namespace App\Service\Api;

use Illuminate\Support\Facades\Http;

class ApiService
{
    public function getAtivos(array $ativos)
    {
        return Http::get(env('API_HGBRASIL') . 'stock_price', [
            'key' => env('KEY_HGBRASIL'),
            'symbol' => implode(',', $ativos)
        ]);
    }
}
