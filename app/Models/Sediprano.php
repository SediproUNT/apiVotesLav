<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Carrera;
use App\Models\Area;

class Sediprano extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'area_id',
        'cargo_id',
        'carrera_id',
        'codigo_qr',
        'estado'
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

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
