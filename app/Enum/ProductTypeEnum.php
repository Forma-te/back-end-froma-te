<?php

namespace App\Enum;

enum ProductTypeEnum: string
{
    case course = 'Curso';
    case ebook = 'Ebook';
    case file = 'Ficheiro';
}
