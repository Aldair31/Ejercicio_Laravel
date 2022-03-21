<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    public $timestamps= false;
    protected $table = 'personas';
    protected $fillable = [
        'Codigo',
        'Nombre',
        'Apellidos',
        'FechaNacimiento',
        'Sexo',
        'Correo',
        'Foto',
        'Vigencia',
        'CodigoPais',
    ];
}
