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
        'total_comprado',
        'total_vendido',
        'qnt_cotas_comprada',
        'qnt_cotas_vendida',
        'valor_ativo',
        'user_id',
        'data_negociacao',
        'mes',
        'ano'
    ];

    ##############################################################################################################
    # RELATIONSHIPS
    ##############################################################################################################
    public function investimento()
    {
        return $this->belongsTo(Investimento::class);
    }
}
