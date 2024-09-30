<?php

namespace App\Enum;

enum SaleEnum: string
{
    case C = 'Iniciado';
    case A = 'Aprovado';
    case E = 'Expirado';
    case P = 'Pendente';
}
