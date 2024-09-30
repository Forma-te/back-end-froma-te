<?php

namespace App\Enum;

enum statusEnum: string
{
    case C = 'C';  // Iniciado
    case A = 'A';  // Aprovado
    case E = 'E';  // Expirado
    case P = 'P';  // Pendente

    public function label(): string
    {
        return match ($this) {
            self::C => 'Iniciado',
            self::A => 'Aprovado',
            self::E => 'Expirado',
            self::P => 'Pendente',
        };
    }
}
