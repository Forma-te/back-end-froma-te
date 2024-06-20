<?php

namespace App\Enum;

enum SupportEnum: string
{
    case P = 'Pendente';
    case A = 'Aguardado Aluno';
    case C = 'Finalizado';
}
