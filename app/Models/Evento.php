<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evento extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
        'ubicacion'
    ];

    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class);
    }
}
