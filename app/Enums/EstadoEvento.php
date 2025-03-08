<?php

namespace App\Enums;

enum EstadoEvento: string
{
    case Programado = 'programado';
    case EnCurso = 'en_curso';
    case Finalizado = 'finalizado';
    case Cancelado = 'cancelado';
}
