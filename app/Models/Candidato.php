<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    protected $fillable = [
        'sediprano_id',
        'cargo_id',
        'area_id',
        'votacion_id',
        'foto'
    ];

    public function sediprano()
    {
        return $this->belongsTo(Sediprano::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function votacion()
    {
        return $this->belongsTo(Votacion::class);
    }

    public function votos()
    {
        return $this->hasMany(Voto::class);
    }
}
