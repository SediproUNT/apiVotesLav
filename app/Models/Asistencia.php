<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'sediprano_id',
        'fecha',
        'hora_ingreso',
        'estado',
        'participacion'
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_ingreso' => 'datetime:H:i',
        'participacion' => 'boolean'
    ];

    public function sediprano()
    {
        return $this->belongsTo(Sediprano::class);
    }
}
