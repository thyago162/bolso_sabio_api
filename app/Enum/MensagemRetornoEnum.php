<?php

namespace App\Enum;

enum MensagemRetornoEnum: string
{
    case NOT_FOUND = 'Recurso não encontrado';
    case ERROR = 'Recurso temporariamente indisponível';
    case ATIVO_NAO_ENCONTRADO = 'Ativo não encontrado, verifique o nome e tente novamente';
    case SAVE_CATEGORIA_FAIL = 'Falha ao tentar salvar uma nova categoria';
}
