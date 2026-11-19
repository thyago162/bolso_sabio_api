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
            'nome_completo' => env("ADMIN_NOME"),
            'email' => env("ADMIN_EMAIL"),
            'cpf' => env("ADMIN_CPF"),
            'ddd' => env("ADMIN_DDD"),
            'telefone' => env("ADMIN_TELEFONE"),
            'password' => bcrypt(env("ADMIN_PWD"))
        ]);
    }
}
