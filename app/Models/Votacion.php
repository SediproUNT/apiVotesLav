<?php

namespace App\Models;

use App\Enums\EstadoVotacion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Votacion extends Model
{
    use HasFactory;

    protected $table = 'votaciones';

    protected $fillable = [
        'name',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'descripcion',
        'estado'
    ];

    protected $casts = [
        'fecha' => 'date',
        'estado' => EstadoVotacion::class
    ];

    protected static function booted()
    {
        static::retrieved(function ($votacion) {
            // Actualizar estado al recuperar el modelo
            $ahora = now();
            $fechaHoraInicio = Carbon::parse($votacion->fecha->format('Y-m-d') . ' ' . $votacion->hora_inicio);
            $fechaHoraFin = Carbon::parse($votacion->fecha->format('Y-m-d') . ' ' . $votacion->hora_fin);

            if ($ahora->between($fechaHoraInicio, $fechaHoraFin)) {
                if ($votacion->estado !== EstadoVotacion::Activa) {
                    $votacion->estado = EstadoVotacion::Activa;
                    $votacion->save();
                }
            } elseif ($ahora->lt($fechaHoraInicio)) {
                if ($votacion->estado !== EstadoVotacion::Pendiente) {
                    $votacion->estado = EstadoVotacion::Pendiente;
                    $votacion->save();
                }
            } else {
                if ($votacion->estado !== EstadoVotacion::Finalizada) {
                    $votacion->estado = EstadoVotacion::Finalizada;
                    $votacion->save();
                }
            }
        });

        static::creating(function ($votacion) {
            $ahora = Carbon::now();
            // Convertir la fecha a string en formato Y-m-d antes de concatenar
            $fechaStr = $votacion->fecha instanceof Carbon ?
                $votacion->fecha->format('Y-m-d') :
                Carbon::parse($votacion->fecha)->format('Y-m-d');

            $fechaHoraInicio = Carbon::createFromFormat(
                'Y-m-d H:i',
                $fechaStr . ' ' . substr($votacion->hora_inicio, 0, 5)
            );

            $fechaHoraFin = Carbon::createFromFormat(
                'Y-m-d H:i',
                $fechaStr . ' ' . substr($votacion->hora_fin, 0, 5)
            );

            if ($ahora->between($fechaHoraInicio, $fechaHoraFin)) {
                $votacion->estado = EstadoVotacion::Activa;
            } elseif ($ahora->lt($fechaHoraInicio)) {
                $votacion->estado = EstadoVotacion::Pendiente;
            } else {
                $votacion->estado = EstadoVotacion::Finalizada;
            }
        });
    }

    public function debeEstarActiva(): bool
    {
        $ahora = Carbon::now();
        $fechaStr = $this->fecha->format('Y-m-d');

        $fechaHoraInicio = Carbon::createFromFormat(
            'Y-m-d H:i',
            $fechaStr . ' ' . substr($this->hora_inicio, 0, 5)
        );

        $fechaHoraFin = Carbon::createFromFormat(
            'Y-m-d H:i',
            $fechaStr . ' ' . substr($this->hora_fin, 0, 5)
        );

        return $ahora->between($fechaHoraInicio, $fechaHoraFin);
    }

    public function actualizarEstadoAutomatico()
    {
        $ahora = Carbon::now();
        $fechaStr = $this->fecha->format('Y-m-d');

        $fechaHoraInicio = Carbon::createFromFormat(
            'Y-m-d H:i',
            $fechaStr . ' ' . substr($this->hora_inicio, 0, 5)
        );

        $fechaHoraFin = Carbon::createFromFormat(
            'Y-m-d H:i',
            $fechaStr . ' ' . substr($this->hora_fin, 0, 5)
        );

        if ($ahora->between($fechaHoraInicio, $fechaHoraFin)) {
            $this->estado = EstadoVotacion::Activa;
        } elseif ($ahora->lt($fechaHoraInicio)) {
            $this->estado = EstadoVotacion::Pendiente;
        } else {
            $this->estado = EstadoVotacion::Finalizada;
        }

        $this->save();
    }

    // Mutadores para asegurar el formato correcto
    public function setHoraInicioAttribute($value)
    {
        $this->attributes['hora_inicio'] = substr($value, 0, 5);
    }

    public function setHoraFinAttribute($value)
    {
        $this->attributes['hora_fin'] = substr($value, 0, 5);
    }

    public function votos()
    {
        return $this->hasMany(Voto::class);
    }
}
