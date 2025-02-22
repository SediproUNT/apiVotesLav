<?php

namespace App\Enums;

enum EstadoVotacion: string
{
    case Pendiente = 'pendiente';
    case Activa = 'activa';
    case Finalizada = 'finalizada';
}
