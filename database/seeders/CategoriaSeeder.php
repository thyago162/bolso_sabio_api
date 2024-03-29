<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nome' => 'Fundo de investimento de Índice',  'tipo_investimento_id' => 10],
            ['nome' => 'Título',  'tipo_investimento_id' => 3],
            ['nome' => 'Título', 'tipo_investimento_id' => 1],
            ['nome' => 'Título', 'tipo_investimento_id' => 4],
            ['nome' => 'Título', 'tipo_investimento_id' => 5],
            ['nome' => 'Título', 'tipo_investimento_id' => 6],
        ];

        foreach ($categorias as $categoria) {
            Categoria::firstOrCreate([
                'nome' => $categoria['nome'],
                'tipo_investimento_id' => $categoria['tipo_investimento_id']
            ]);
        }
    }
}
