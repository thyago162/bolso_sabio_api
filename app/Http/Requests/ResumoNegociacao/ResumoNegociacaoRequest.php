<?php

namespace App\Http\Requests\ResumoNegociacao;

use Illuminate\Foundation\Http\FormRequest;

class ResumoNegociacaoRequest extends FormRequest
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
            'investimento_id' => 'required',
            'quantidade' => 'required|integer|gte:0',
            'data_negociacao' => 'required',
            'total_comprado' => 'required',
            'total_vendido' => 'required',
            'qnt_cotas_comprada' => 'required',
            'qnt_cotas_vendida' => 'required',
            'valor_ativo' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'investimento_id.required' => 'Selecione um investimento',
            'quantidade.required' => 'O campo QUANTIDADE é obrigatório',
            'quantidade.integer' => 'O campo QUANTIDADE deve ser um número',
            'quantidade.gte:0' => 'O campo QUANTIDADE deve ser maior ou igual a 0',
            'qnt_cotas_comprada.required' => 'O campo QUANTIDADE é obrigatório',
            'qnt_cotas_vendida.required' => 'O campo QUANTIDADE é obrigatório',
            'data_negociacao.required' => 'O campo DATA NEGOCIAÇÃO é obrigatório',
            'valor_ativo.required' => 'O campo PREÇO DE COMPRA é obrigatório'
        ];
    }
}
