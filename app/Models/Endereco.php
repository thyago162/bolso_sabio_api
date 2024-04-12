<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = 'enderecos';

    protected $fillable = [
        'tipo_logradouro',
        'logradouro',
        'complemento',
        'numero',
        'bairro',
        'cidade',
        'estaado',
        'cep',
        'user_id'
    ];
}
