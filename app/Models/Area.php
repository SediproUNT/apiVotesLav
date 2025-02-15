<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['nombre', 'abreviatura'];

    public function candidatos()
    {
        return $this->hasMany(Candidato::class);
    }
}
