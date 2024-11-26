<?php

namespace App\Enum;

enum SaleEnum: string
{
    case A = 'Aprovado';
    case E = 'Expirado';
    case P = 'Pendente';
}
