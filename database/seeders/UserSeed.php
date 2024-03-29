<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nome_completo' => 'Administrador',
            'email' => 'thyago@email.com',
            'cpf' => '05928183496',
            'ddd' => '83',
            'telefone' => '999310936',
            'password' => bcrypt('l1nux222')
        ]);
    }
}
