<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Sediprano extends Model
{
    protected $fillable = [
        'codigo', 'dni', 'primer_apellido', 'segundo_apellido',
        'carrera', 'celular', 'fecha_nacimiento', 'user_id'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function candidato()
    {
        return $this->hasOne(Candidato::class);
    }

    public function votos()
    {
        return $this->hasMany(Voto::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}
