<?php

namespace App\Service\User;

use App\Models\User;

class UserService
{
    public function show()
    {
        return User::with('endereco')->findOrFail(auth()->id());
    }

    public function update($data, $id)
    {
        $user = User::find($id)->update([
            'nome_completo' => $data['user']['nome_completo'],
            'email' => $data['user']['email'],
            'cpf' => $data['user']['cpf'],
            'ddd' => $data['user']['ddd'],
            'telefone' => $data['user']['telefone']
        ]);

        $user->endereco()->updateOrCreate(['cep' => $data['endereco']['cep']], [
            'tipo_logradouro' => $data['endereco']['tipo_logradouro'],
            'logradouro' => $data['endereco']['logradouro'],
            'numero' => $data['endereco']['numero'],
            'complemento' => $data['endereco']['complemento'],
            'bairro' => $data['endereco']['bairro'],
            'cidade' => $data['endereco']['cidade'],
            'estado' => $data['endereco']['estado'],
            'cep' => $data['endereco']['cep']
        ]);

        return $user->load('endereco');
    }
}
