<?php

namespace App\Enum;

enum SupportEnum: string
{
    case P = 'Pendente';
    case A = 'Aguardado Membro';
    case C = 'Finalizado';
}
