<?php

namespace App\Http\Requests\Investimento;

use Illuminate\Foundation\Http\FormRequest;

class InvestimentoRequest extends FormRequest
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
            'descricao' => 'required|max:255',
            'tipo_investimento_id' => "required",
            'quantidade' => "required|integer|gte:0",
            'valor_bruto' => "required",
            'valor_liquido' => "required",
            'valor_investido' => "required",
            'taxa_negociada' => "max:255",
        ];
    }

    public function messages()
    {
        return [
            'descricao.required' => 'O campo DESCRIÇÃO é obrigatório',
            'descricao.max:255' => 'O campo DESCRIÇÃO é muito grande',
            'tipo_investimento_id' => 'O campo TIPO INVESTIMENTO é obrigatório',
            'quantidade.required' => 'O campo QUANTIDADE é obrigatório',
            'quantidade.integer' => 'O campo QUANTIDADE deve ser um número',
            'quantidade.gte:0' => 'O campo QUANTIDADE não pode ser menor do que 0',
            'valor_bruto.required' => 'O campo VALOR BRUTO é obrigatório',
            'valor_liquido.required' => 'O campo VALOR LÍQUIDO é obrigatório',
            'valor_investido.required' => 'O campo VALOR INVESTIDO é obrigatório'
        ];
    }
}
