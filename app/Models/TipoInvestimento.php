<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoInvestimento extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'tipo_renda', 'alias'];
}
