<?php

namespace App\Enum;

enum MensagemRetornoEnum: string
{
    case NOT_FOUND = 'Recurso não encontrado';
    case ERROR = 'Recurso temporariamente indisponível';
}
