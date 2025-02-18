<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carreras';

    protected $fillable = ['nombre'];

    public function sedipranos()
    {
        return $this->hasMany(Sediprano::class);
    }
}
