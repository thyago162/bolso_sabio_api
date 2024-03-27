<?php

namespace App\Service\Erro;

use App\Enum\MensagemRetornoEnum;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ErroService
{
    public static function report($exception)
    {
        $erro = [
            'mensagem' => MensagemRetornoEnum::ERROR->value,
            'codigo' => 500
        ];

        if ($exception instanceof ModelNotFoundException) {
            $erro['mensagem'] = 'Recurso não encontrado';
            $erro['codigo'] = 404;
        }

        return response()->json(['mensagem' => $erro['mensagem']], $erro['codigo']);
    }
}
