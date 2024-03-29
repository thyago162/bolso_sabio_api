<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministradoraInvestimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'administradora_id',
        'investimento_id'
    ];

    #############################################################################################################
    # RELATIONSHIPS
    ##############################################################################################################
    public function administradora()
    {
        return $this->belongsTo(Administradora::class);
    }

    public function Investimento()
    {
        return $this->hasOne(Investimento::class);
    }
}
