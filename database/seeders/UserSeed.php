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
            'email' => 'admin@bolsosabio.com',
            'cpf' => '000000000000',
            'ddd' => '83',
            'telefone' => '999310935',
            'password' => bcrypt('l1nux222')
        ]);
    }
}
