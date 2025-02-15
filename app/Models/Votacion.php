<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Votacion extends Model
{
    protected $table = 'votaciones';

    protected $fillable = ['fecha', 'hora_inicio', 'hora_fin', 'descripcion', 'estado'];

    protected $casts = [
        'fecha' => 'date',
        'hora_inicio' => 'datetime',
        'hora_fin' => 'datetime'
    ];

    public function votos()
    {
        return $this->hasMany(Voto::class);
    }
}
