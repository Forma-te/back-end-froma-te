<?php

namespace App\Enum;

enum SaleEnum: string
{
    case C = 'Iniciado, Aguardar Validação';
    case A = 'Aprovado';
    case E = 'Expirado';
    case P = 'Pendente';
}
