<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    protected $fillable = ['sediprano_id', 'candidato_id', 'votacion_id', 'fecha_voto'];

    protected $casts = [
        'fecha_voto' => 'datetime'
    ];

    public function sediprano()
    {
        return $this->belongsTo(Sediprano::class);
    }

    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

    public function votacion()
    {
        return $this->belongsTo(Votacion::class);
    }
}
