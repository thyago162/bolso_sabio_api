<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumoNegociacao extends Model
{
    use HasFactory;

    protected $table = 'resumo_negociacoes';
    protected $fillable = [
        'investimento_id',
        'total_compras',
        'total_vendas',
        'qnt_compras',
        'qnt_vendas',
        'valor_ativo',
        'user_id',
        'data_negociacao'
    ];

    ##############################################################################################################
    # RELATIONSHIPS
    ##############################################################################################################
    public function investimento()
    {
        return $this->belongsTo(Investimento::class);
    }
}
