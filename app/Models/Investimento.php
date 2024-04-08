<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;


class Investimento extends Model
{
    use HasFactory, SoftDeletes;

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

    public function administradoraInvestimento()
    {
        return $this->hasOne(AdministradoraInvestimento::class);
    }

    ###############################################################################################################
    # CAST E MUTATORS
    ################################################################################################################
    protected function valorBruto(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => str_replace('.', ',', $value),
        );
    }

    protected function vencimento(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->format('d/m/Y') : ''
        );
    }

    ###################################################################################################################
    # SCOPE
    public function scopeTipoInvestimento($query, $tipo_investimento_id)
    {
        if ($tipo_investimento_id) {
            $query->where('tipo_investimento_id', $tipo_investimento_id);
        }

        return $query;
    }
}
