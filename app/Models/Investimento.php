<?php

namespace App\Models;

use App\Casts\ValorInvestido;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'categoria_id',
        'user_id',
        'tipo_investimento_id',
        'quantidade',
        'valor_unitario',
        'valor_aplicado',
        'valor_bruto',
        'valor_liquido',
        'taxa_negociada',
        'vencimento'
    ];

    protected $casts = [
        'valor_investido' => ValorInvestido::class
    ];

    ################################################################################################################
    # RELATIONSHIPS

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tipoInvestimento()
    {
        return $this->belongsTo(TipoInvestimento::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
