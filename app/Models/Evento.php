<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    public $timestamps= false;
    protected $table = 'eventos';
    protected $fillable = [
        'Codigo',
        'Titulo',
        'Descripcion',
        'Fecha',
        'Imagen',
        'URL',
        'Vigencia',
        'CodigoLineaTiempo',
    ];
}
