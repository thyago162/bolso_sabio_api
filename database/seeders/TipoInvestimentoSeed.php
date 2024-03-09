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
        TipoInvestimento::firstOrCreate(['nome' => 'Tesouro Direto', 'tipo_renda' => 'Fixa', 'alias' => '']);
        TipoInvestimento::firstOrCreate(['nome' => 'LCI e LCA', 'tipo_renda' => 'Fixa', 'alias' => '']);
        TipoInvestimento::firstOrCreate(['nome' => 'CDB e LC', 'tipo_renda' => 'Fixa', 'alias' => '']);
        TipoInvestimento::firstOrCreate(['nome' => 'Debentures', 'tipo_renda' => 'Fixa', 'alias' => '']);
        TipoInvestimento::firstOrCreate(['nome' => 'CRI e CRA', 'tipo_renda' => 'Fixa', 'alias' => '']);
        TipoInvestimento::firstOrCreate(['nome' => 'Letra Financeira', 'tipo_renda' => 'Fixa', 'alias' => '']);
        TipoInvestimento::firstOrCreate(['nome' => 'Ações', 'tipo_renda' => 'Variável', 'alias' => 'stock']);
        TipoInvestimento::firstOrCreate(['nome' => 'BDRs', 'tipo_renda' => 'Variável', 'alias' => 'dbr']);
        TipoInvestimento::firstOrCreate(['nome' => 'Fundos Imobiliários', 'tipo_renda' => 'Variável', 'alias' => 'fii']);
        TipoInvestimento::firstOrCreate(['nome' => 'ETFs', 'tipo_renda' => 'Variável', 'alias' => 'etf']);
    }
}
