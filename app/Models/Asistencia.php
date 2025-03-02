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

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }

    public function sediprano(): BelongsTo
    {
        return $this->belongsTo(Sediprano::class);
    }
}
