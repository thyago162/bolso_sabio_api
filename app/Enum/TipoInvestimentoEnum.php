<?php

namespace App\Enum;

enum TipoInvestimentoEnum: int
{
    case TESOURO_DIRETO = 1;
    case LCI_LCA = 2;
    case CDB_LCA = 3;
    case DEBENTURES = 4;
    case CRI_CRA = 5;
    case LETRAS = 6;
    case ACOES = 7;
    case BDR = 8;
    case FII = 9;
    case ETF = 10;
}
