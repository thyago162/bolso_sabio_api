<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administradora extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
        'descricao',
        'site',
        'logo'
    ];

    #############################################################################################################
    # RELATIONSHIPS
    ##############################################################################################################
    public function AdministradoraInvestimento()
    {
        return $this->hasMany(AdministradoraInvestimento::class);
    }
}
