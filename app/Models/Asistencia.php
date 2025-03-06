<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    protected $fillable = [
        'evento_id',
        'sediprano_id',
        'hora_registro',
        'estado',
        'observacion'
    ];

    protected $casts = [
        'hora_registro' => 'datetime',
    ];

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }

    public function sediprano(): BelongsTo
    {
        return $this->belongsTo(Sediprano::class);
    }

    /**
     * Acceso directo al usuario asociado con este sediprano
     */
    public function usuario()
    {
        return $this->sediprano->user();
    }

    /**
     * Acceso directo al cargo del sediprano
     */
    public function cargo()
    {
        return $this->sediprano->cargo();
    }

    /**
     * Acceso directo al área del sediprano
     */
    public function area()
    {
        return $this->sediprano->area();
    }

    /**
     * Obtener información completa del sediprano con sus relaciones
     */
    public function getSedipranoInfoAttribute()
    {
        if (!$this->relationLoaded('sediprano')) {
            $this->load('sediprano.user', 'sediprano.carrera', 'sediprano.cargo', 'sediprano.area');
        }

        $sediprano = $this->sediprano;
        
        return [
            'id' => $sediprano->id,
            'codigo' => $sediprano->codigo,
            'primer_apellido' => $sediprano->primer_apellido,
            'segundo_apellido' => $sediprano->segundo_apellido,
            'nombre_completo' => $sediprano->user->name,
            'carrera' => $sediprano->carrera ? $sediprano->carrera->nombre : null,
            'area' => $sediprano->area ? $sediprano->area->abreviatura : null,  // Usar abreviatura en lugar de nombre
            'cargo' => $sediprano->cargo ? $sediprano->cargo->nombre : null
        ];
    }
}
