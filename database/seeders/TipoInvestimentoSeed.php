<?php

namespace Database\Seeders;

use App\Models\TipoInvestimento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoInvestimentoSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoInvestimento::firstOrCreate(['nome' => 'Tesouro Direto', 'tipo_renda' => 'Fixa', 'alias' => '', 'cor' => '#FF8C00']);
        TipoInvestimento::firstOrCreate(['nome' => 'LCI e LCA', 'tipo_renda' => 'Fixa', 'alias' => '', 'cor' => '#8A2BE2']);
        TipoInvestimento::firstOrCreate(['nome' => 'CDB e LC', 'tipo_renda' => 'Fixa', 'alias' => '', 'cor' => '#00FF7F']);
        TipoInvestimento::firstOrCreate(['nome' => 'Debentures', 'tipo_renda' => 'Fixa', 'alias' => '', 'cor' => '#20B2AA']);
        TipoInvestimento::firstOrCreate(['nome' => 'CRI e CRA', 'tipo_renda' => 'Fixa', 'alias' => '', 'cor' => '#4682B4']);
        TipoInvestimento::firstOrCreate(['nome' => 'Letra Financeira', 'tipo_renda' => 'Fixa', 'alias' => '', 'cor' => '#A52A2A']);
        TipoInvestimento::firstOrCreate(['nome' => 'Ação', 'tipo_renda' => 'Variável', 'alias' => 'stock', 'cor' => '#483D8B']);
        TipoInvestimento::firstOrCreate(['nome' => 'BDR', 'tipo_renda' => 'Variável', 'alias' => 'dbr', 'cor' => '#556B2F']);
        TipoInvestimento::firstOrCreate(['nome' => 'FII', 'tipo_renda' => 'Variável', 'alias' => 'fii', 'cor' => '#191970']);
        TipoInvestimento::firstOrCreate(['nome' => 'ETF', 'tipo_renda' => 'Variável', 'alias' => 'etf', 'cor' => '#2F4F4F']);
    }
}
