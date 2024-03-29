<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'tipo_investimento_id'];

    #############################################################################################################
    #CASTING E MUTATORS
    ##############################################################################################################
    protected function nome(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $categoria = explode('/', $value);
                return end($categoria);
            }
        );
    }

}
