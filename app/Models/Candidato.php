<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    protected $fillable = ['sediprano_id', 'cargo_id', 'foto', 'area_id'];

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

    public function votos()
    {
        return $this->hasMany(Voto::class);
    }
}
