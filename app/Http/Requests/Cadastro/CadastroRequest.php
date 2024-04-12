<?php

namespace App\Http\Requests\Cadastro;

use Illuminate\Foundation\Http\FormRequest;

class CadastroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome_completo' => 'required|string|max:255|min:8',
            'cpf' => 'required|string|unique:users|max:14',
            'email' => 'required|string:users|max:255|email:rfc,dns|unique:users',
            'ddd' => 'required|string',
            'telefone' => 'required|string',
            'password' => 'required|string|confirmed',
        ];
    }
}
